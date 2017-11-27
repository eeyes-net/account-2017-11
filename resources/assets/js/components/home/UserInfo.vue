<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">个人信息</div>

                    <div class="panel-body">
                        <div class="row" v-for="(value, key) in userFieldName">
                            <div class="col-md-3">{{ userFieldName[key] }}</div>
                            <div class="col-md-9">{{ user[key] }}</div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">个人信息修改</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">{{ userFieldName['email'] }}</div>
                            <div class="col-md-9"><input type="text" style="min-width: 20em;" v-model="user['email']"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">{{ userFieldName['mobile'] }}</div>
                            <div class="col-md-9"><input type="text" style="min-width: 20em;" v-model="user['mobile']"></div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <button class="btn btn-primary" @click="updateUserInfo">保存</button>
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
                userFieldName: {
                    username: 'NetId',
                    user_id: '学号',
                    mobile: '手机号码',
                    name: '姓名',
                    email: '邮箱',
                    gender: '性别',
                    birthday: '生日',
                    classid: '班级名称',
                    dep: '学院名称',
                    speciality: '专业名称',
                    depid: '学院id',
                    roomnumber: '宿舍地址',
                    idcardname: '证件类型',
                    idcardno: '证件号码',
                    marriage: '“已婚”或“未婚”',
                    nation: '民族',
                    nationplace: '籍贯',
                    polity: '政治面貌',
                    studenttype: '考生类型',
                    tutoremployeeid: '导师姓名',
                    usertype: '身份',
                    roomphone: '宿舍电话'
                },
                user: {
                    username: '',
                    user_id: '',
                    mobile: '',
                    name: '',
                    email: '',
                    gender: '',
                    birthday: '',
                    classid: '',
                    dep: '',
                    speciality: '',
                    depid: '',
                    roomnumber: '',
                    idcardname: '',
                    idcardno: '',
                    marriage: '',
                    nation: '',
                    nationplace: '',
                    polity: '',
                    studenttype: '',
                    tutoremployeeid: '',
                    usertype: '',
                    roomphone: ''
                }
            };
        },

        ready() {
            this.prepareComponent();
        },

        mounted() {
            this.prepareComponent();
        },

        methods: {
            prepareComponent() {
                this.getUserInfo();
            },

            getUserInfo() {
                axios.get('/api/user')
                    .then(response => {
                        this.user = response.data;
                    });
            },

            updateUserInfo() {
                axios.put('/api/user', {
                    email: this.user.email,
                    mobile: this.user.mobile
                }).then(response => {
                    alert(response.data.message);
                });
            }
        }
    }
</script>
