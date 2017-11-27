<template>
    <div>
        <div>
            <h2 class="sub-header">权限 <a class="btn btn-primary" @click="create">创建</a></h2>
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
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="permission in permissions">
                        <td>{{ permission.id }}</td>
                        <td>{{ permission.name }}</td>
                        <td>{{ permission.display_name }}</td>
                        <td>
                            <a class="btn btn-primary" @click="edit(permission)">编辑</a>
                            <a class="btn btn-danger" @click="destroy(permission)">删除</a>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">创建权限</h4>
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
                                    <input type="text" class="form-control" name="display_name"
                                           v-model="createForm.display_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">描述</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description"
                                              v-model="createForm.description"></textarea>
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
        <div class=" modal fade" tabindex="-1" role="dialog" ref="editModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">修改权限信息</h4>
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
                                    <input type="text" class="form-control" name="display_name"
                                           v-model="editForm.display_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">描述</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description"
                                              v-model="editForm.description"></textarea>
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
                errors: [],

                createForm: {
                    errors: [],
                    name: '',
                    display_name: '',
                    description: ''
                },

                editForm: {
                    errors: [],
                    id: 0,
                    name: '',
                    display_name: '',
                    description: ''
                }
            };
        },

        mounted() {
            this.getPermissions();
        },

        methods: {
            getPermissions() {
                axios.get('/admin/api/permission')
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

            create() {
                $(this.$refs.createModal).modal('show');
            },

            store() {
                const form = this.createForm;
                form.errors = [];
                axios.post('/admin/api/permission', {
                    name: form.name,
                    display_name: form.display_name,
                    description: form.description
                })
                    .then(response => {
                        this.getPermissions();
                        form.name = '';
                        form.display_name = '';
                        form.description = '';
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

            edit(permission) {
                this.editForm.id = permission.id;
                this.editForm.name = permission.name;
                this.editForm.display_name = permission.display_name;
                this.editForm.description = permission.description;
                $(this.$refs.editModal).modal('show');
            },

            update() {
                const form = this.editForm;
                form.errors = [];
                axios.put('/admin/api/permission/' + form.id, {
                    name: form.name,
                    display_name: form.display_name,
                    description: form.description
                })
                    .then(response => {
                        this.getPermissions();
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

            destroy(permission) {
                axios.delete('/admin/api/permission/' + permission.id)
                    .then(response => {
                        this.errors = [];
                        this.getPermissions();
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
