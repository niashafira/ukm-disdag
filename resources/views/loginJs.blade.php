
<script>
    var app = new Vue({
        el: '#app',
        data: {
            api:{
                login: '/login'
            },
            validation: "",
            username: "",
            password: ""
        },

        mounted(){
            this.initValidation();
        },

        methods: {
            initValidation(){
                this.validation = FormValidation.formValidation(
                    document.getElementById('loginForm'),
                    {
                        fields: {
                            username: {
                                validators: {
                                    notEmpty: {
                                        message: 'Username tidak boleh kosong'
                                    }
                                }
                            },
                            password: {
                                validators: {
                                    notEmpty: {
                                        message: 'Password tidak boleh kosong'
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            // Bootstrap Framework Integration
                            bootstrap: new FormValidation.plugins.Bootstrap({
                                //eleInvalidClass: '',
                                eleValidClass: '',
                            })
                        }
                    }
                );
            },

            async submitLogin(){
                this.validation.validate().then(async (status) => {
					if (status == 'Valid') {
                        Swal.fire({
                            title: 'Mohon Tunggu...',
                            html: '',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        });
                        var data = {
                            username: this.username,
                            password: this.password
                        }

                        const response = await axios.post(this.api.login, data);

                        Swal.close();

                        if(response.data.status == 'E'){
                            Swal.fire({
                                type: 'error',
                                title: '',
                                text: response.data.message
                            });
                        }
                        else if(response.data.status == "S"){
                            window.location.href = '/dashboard';
                        }
					}
				});
            }
        },
    });

    </script>
