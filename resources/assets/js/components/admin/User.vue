<template>
    <div>
        <div>
            <h2 class="sub-header">用户 <a class="btn btn-primary" @click="create">创建</a></h2>
            <div class="alert alert-danger" v-if="errors.length > 0">
                <p><strong>糟糕！</strong>出了一些问题。</p>
                <br>
                <ul>
                    <li v-for="error in errors">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>用户名（NetID）</th>
                        <th>姓名</th>
                        <th>角色</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users">
                        <td>{{ user.id }}</td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.name }}</td>
                        <td>
                            <span class="badge badge-primary" v-for="role_id in user.role_ids">{{ rolesById[role_id].display_name }}</span>
                        </td>
                        <td>
                            <a class="btn btn-primary" @click="edit(user)">编辑</a>
                            <a class="btn btn-danger" @click="destroy(user)">删除</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation">
                <div class="form-inline">
                    <div class="form-group">
                        <ul class="pagination">
                            <li :class="{'disabled': (usersPagination.current_page <= 1)}">
                                <a aria-label="Previous" @click="getUsers(usersPagination.current_page - 1)">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li :class="{'active': pageObject.isCurrent, 'disabled': pageObject.paginationEllipsis}" v-for="pageObject in userPageList">
                                <span v-if="pageObject.paginationEllipsis">&hellip;</span>
                                <a v-else @click="getUsers(pageObject.page)">{{ pageObject.page }}</a>
                            </li>
                            <li :class="{'disabled': (usersPagination.current_page >= usersPagination.last_page)}">
                                <a aria-label="Next" @click="getUsers(usersPagination.current_page + 1)">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="toPage" v-model="toPage" @keyup.enter="getUsers(toPage)">
                    </div>
                    <button type="submit" class="btn btn-default" @click="getUsers(toPage)">转到</button>
                </div>
            </nav>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" ref="createModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">创建用户</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p><strong>糟糕！</strong>出了一些问题。</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                        <form class="form-horizontal" role="form" @submit.prevent="store">
                            <div class="form-group">
                                <label class="col-md-4 control-label">用户名（NetID）</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username" v-model="createForm.username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">角色</label>
                                <div class="col-md-6">
                                    <div v-for="role in roles">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" @click="toggleRole(createForm, role.id)" :checked="roleIsAssigned(createForm, role.id)">
                                                {{ role.display_name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" @click="store">创建</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" ref="editModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">修改用户信息</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p><strong>糟糕！</strong>出了一些问题。</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                        <form class="form-horizontal" role="form" @submit.prevent="update">
                            <div class="form-group">
                                <label class="col-md-4 control-label">用户名（NetID）</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username" disabled v-model="editForm.username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">姓名</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" disabled v-model="editForm.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">学工号</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="user_id" disabled v-model="editForm.user_id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">E-mail</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="email" v-model="editForm.email"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">联系方式</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="mobile" v-model="editForm.mobile"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">角色</label>
                                <div class="col-md-6">
                                    <div v-for="role in roles">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" @click="toggleRole(editForm, role.id)" :checked="roleIsAssigned(editForm, role.id)">
                                                {{ role.display_name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" @click="update">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                usersPagination: {},

                roles: [],
                users: [],
                errors: [],

                toPage: 1,

                createForm: {
                    errors: [],
                    username: '',
                    role_ids: []
                },

                editForm: {
                    errors: [],
                    id: 0,
                    username: '',
                    name: '',
                    user_id: '',
                    email: '',
                    mobile: '',
                    role_ids: []
                }
            };
        },

        computed: {
            rolesById() {
                return _.keyBy(this.roles, 'id');
            },

            userPageList() {
                const data = this.usersPagination;
                return this.pageList(data.current_page, data.last_page);
            }
        },

        mounted() {
            this.getRoles();
            this.getUsers();
        },

        methods: {
            getRoles() {
                axios.get('/api/admin/role')
                    .then(response => {
                        this.roles = response.data;
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            this.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            this.errors = ['出现了一些问题，请重试。'];
                        }
                    });
            },

            getUsers(page = null) {
                if (page === null) {
                    if (this.usersPagination.current_page) {
                        page = this.usersPagination.current_page;
                    } else {
                        page = 1;
                    }
                } else if (page <= 1) {
                    page = 1;
                } else if (page >= this.usersPagination.last_page) {
                    page = this.usersPagination.last_page;
                }
                axios.get('/api/admin/user?page=' + page)
                    .then(response => {
                        this.usersPagination = response.data;
                        this.users = this.usersPagination.data;
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            this.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            this.errors = ['出现了一些问题，请重试。'];
                        }
                    });
            },

            toggleRole(form, roleId) {
                if (this.roleIsAssigned(form, roleId)) {
                    form.role_ids = _.reject(form.role_ids, s => s === roleId);
                } else {
                    form.role_ids.push(roleId);
                }
            },

            roleIsAssigned(form, roleId) {
                return _.indexOf(form.role_ids, roleId) >= 0;
            },

            create() {
                $(this.$refs.createModal).modal('show');
            },

            store() {
                const form = this.createForm;
                form.errors = [];
                axios.post('/api/admin/user', {
                    username: form.username,
                    role_ids: form.role_ids
                })
                    .then(response => {
                        if (response.data.errors) {
                            form.errors = [response.data.errors];
                        } else {
                            this.getUsers(this.usersPagination.current_page);
                            form.username = '';
                            form.role_ids = [];
                            $(this.$refs.createModal).modal('hide');
                        }
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['出现了一些问题，请重试。'];
                        }
                    });
            },

            edit(user) {
                const form = this.editForm;
                form.id = user.id;
                form.username = user.username;
                form.name = user.name;
                form.user_id = user.user_id;
                form.email = user.email;
                form.mobile = user.mobile;
                form.role_ids = _.clone(user.role_ids);
                $(this.$refs.editModal).modal('show');
            },

            update() {
                const form = this.editForm;
                form.errors = [];
                axios.put('/api/admin/user/' + form.id, {
                    username: form.username,
                    name: form.name,
                    user_id: form.user_id,
                    email: form.email,
                    mobile: form.mobile,
                    role_ids: form.role_ids
                })
                    .then(response => {
                        this.getUsers();
                        $(this.$refs.editModal).modal('hide');
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['出现了一些问题，请重试。'];
                        }
                    });
            },

            destroy(user) {
                axios.delete('/api/admin/user/' + user.id)
                    .then(response => {
                        this.errors = [];
                        this.getUsers();
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            this.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            this.errors = ['出现了一些问题，请重试。'];
                        }
                    });
            },

            /**
             * 页码列表
             * @link https://gist.github.com/kottenator/9d936eb3e4e3c3e02598
             * @return {Array}
             */
            pageList(current, last, delta = 2) {
                let left = current - delta;
                let right = current + delta;
                let range = [];
                for (let i = 1; i <= last; ++i) {
                    if (i === 1 || i === last || i >= left && i <= right) {
                        range.push(i);
                    }
                }
                let result = [];
                let lastPage = 0;
                for (let i = 0; i < range.length; ++i) {
                    let page = range[i];
                    let deltaPage = page - lastPage;
                    if (deltaPage > 2) {
                        result.push({
                            page: '...',
                            paginationEllipsis: true,
                            isCurrent: false
                        });
                    } else {
                        if (deltaPage === 2) {
                            result.push({
                                page: page - 1,
                                paginationEllipsis: false,
                                isCurrent: false
                            });
                        }
                    }
                    result.push({
                        page: page,
                        paginationEllipsis: false,
                        isCurrent: (page === current)
                    });
                    lastPage = page;
                }
                return result;
            },
        }
    }
</script>
