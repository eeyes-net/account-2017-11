<template>
    <div>
        <div>
            <h2 class="sub-header">角色 <a class="btn btn-primary" @click="create">创建</a></h2>
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
                        <th>代号</th>
                        <th>名称</th>
                        <th>权限</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="role in roles">
                        <td>{{ role.id }}</td>
                        <td>{{ role.name }}</td>
                        <td>{{ role.display_name }}</td>
                        <td>
                            <span class="badge badge-primary" v-for="perm_id in role.perm_ids">{{ permissionsById[perm_id].display_name }}</span>
                        </td>
                        <td>
                            <a class="btn btn-primary" @click="edit(role)">编辑</a>
                            <a class="btn btn-danger" @click="destroy(role)">删除</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" ref="createModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">创建角色</h4>
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
                                <label class="col-md-4 control-label">代号</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" v-model="createForm.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">名称</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="display_name" v-model="createForm.display_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">描述</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description" v-model="createForm.description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">权限</label>
                                <div class="col-md-6">
                                    <div v-for="permission in permissions">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" @click="togglePermission(createForm, permission.id)" :checked="permissionIsAssigned(createForm, permission.id)">
                                                {{ permission.display_name }}
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
                        <h4 class="modal-title">修改角色信息</h4>
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
                                <label class="col-md-4 control-label">代号</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" v-model="editForm.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">名称</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="display_name" v-model="editForm.display_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">描述</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description" v-model="editForm.description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">权限</label>
                                <div class="col-md-6">
                                    <div v-for="permission in permissions">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" @click="togglePermission(editForm, permission.id)" :checked="permissionIsAssigned(editForm, permission.id)">
                                                {{ permission.display_name }}
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
                permissions: [],
                roles: [],
                errors: [],

                createForm: {
                    errors: [],
                    name: '',
                    display_name: '',
                    description: '',
                    perm_ids: []
                },

                editForm: {
                    errors: [],
                    id: 0,
                    name: '',
                    display_name: '',
                    description: '',
                    perm_ids: []
                }
            };
        },

        computed: {
            permissionsById() {
                return _.keyBy(this.permissions, 'id');
            }
        },

        mounted() {
            this.getPermissions();
            this.getRoles();
        },

        methods: {
            getPermissions() {
                axios.get('/api/admin/permission')
                    .then(response => {
                        this.permissions = response.data;
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            this.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            this.errors = ['出现了一些问题，请重试。'];
                        }
                    });
            },

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

            togglePermission(form, permissionId) {
                if (this.permissionIsAssigned(form, permissionId)) {
                    form.perm_ids = _.reject(form.perm_ids, s => s === permissionId);
                } else {
                    form.perm_ids.push(permissionId);
                }
            },

            permissionIsAssigned(form, permissionId) {
                return _.indexOf(form.perm_ids, permissionId) >= 0;
            },

            create() {
                $(this.$refs.createModal).modal('show');
            },

            store() {
                const form = this.createForm;
                form.errors = [];
                axios.post('/api/admin/role', {
                    name: form.name,
                    display_name: form.display_name,
                    description: form.description
                })
                    .then(response => {
                        this.getRoles();
                        form.name = '';
                        form.display_name = '';
                        form.description = '';
                        form.perm_ids = [];
                        $(this.$refs.createModal).modal('hide');
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['出现了一些问题，请重试。'];
                        }
                    });
            },

            edit(role) {
                const form = this.editForm;
                form.id = role.id;
                form.name = role.name;
                form.display_name = role.display_name;
                form.description = role.description;
                form.perm_ids = _.clone(role.perm_ids);
                $(this.$refs.editModal).modal('show');
            },

            update() {
                const form = this.editForm;
                form.errors = [];
                axios.put('/api/admin/role/' + form.id, {
                    name: form.name,
                    display_name: form.display_name,
                    description: form.description,
                    perm_ids: form.perm_ids
                })
                    .then(response => {
                        this.getRoles();
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

            destroy(role) {
                axios.delete('/api/admin/role/' + role.id)
                    .then(response => {
                        this.errors = [];
                        this.getRoles();
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            this.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            this.errors = ['出现了一些问题，请重试。'];
                        }
                    });
            }
        }
    }
</script>
