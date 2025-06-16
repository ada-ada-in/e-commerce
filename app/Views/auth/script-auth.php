<script>

    $(function(){

        function register(){
            const form = $('#form-register').on('submit', function (e) {
                e.preventDefault()
                const form = $(this);
                const formData = {
                    name: form.find('input[name="name"]').val(),
                    email: form.find('input[name="email"]').val(),
                    phone: form.find('input[name="phone"]').val(),
                    address: form.find('input[name="address"]').val(),
                    password: form.find('input[name="password"]').val(),
                    confirm_password: form.find('input[name="confirm_password"]').val()
                };
                $.ajax({
                    url: '/api/v1/auth/register',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response){
                        const message = response.message
                        alert(message)
                        window.location.href = '/auth/login'
                    },  
                    error: function(xhr, status, error){
                        try{
                            const response = JSON.parse(xhr.responseText);
                                let errorMessage = '';
                                if (response.messages) {
                                    for (const key in response.messages) {
                                        if (response.messages.hasOwnProperty(key)) {
                                            errorMessage += `${response.messages[key]}\n`;
                                        }
                                    }
                                } else if (response.message) {
                                    errorMessage = response.message;
                                } else {
                                    errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                                }
                                alert(errorMessage);
                        }catch(e){
                            console.error('Gagal parse response error:', e);
                            alert('Terjadi kesalahan saat memproses respons error.');
                        }
                    }
                })
            })
        }

        register();

        function login() {
            const form = $('#form-login').on('submit', function (e) {   
                e.preventDefault();
                const form = $(this)
                const formData = {
                    email: form.find('input[name="email"]').val(),
                    password: form.find('input[name="password"]').val()
                }
                console.log(formData)
                $.ajax({
                    url: '/api/v1/auth/login',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response){
                        const message = response.message
                        const role = response.role;
                        const id = response.id;
                        localStorage.setItem('userId', id);
                        
                        if(role == 'admin'){
                            window.location.href = '/admin/dashboard'
                        } else {
                            window.location.href = '/'
                        }

                        alert(response.message)
                    },  
                    error: function(xhr, error, status){
                        try{
                                const response = JSON.parse(xhr.responseText);
                                    let errorMessage = '';
                                    if (response.messages) {
                                        for (const key in response.messages) {
                                            if (response.messages.hasOwnProperty(key)) {
                                                errorMessage += `${response.messages[key]}\n`;
                                            }
                                        }
                                    } else if (response.message) {
                                        errorMessage = response.message;
                                    } else {
                                        errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                                    }
                                    alert(errorMessage);
                            }catch(e){
                                console.error('Gagal parse response error:', e);
                                alert('Terjadi kesalahan saat memproses respons error.');
                            }
                    }
                })
            })
        }


        login()

        function logout() {
            $('#logout').on('click', function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/api/v1/auth/logout',
                    type: 'POST',
                    success: function(response) {
                        const message = response.message;
                        alert(message);
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            let errorMessage = '';
                            if (response.messages) {
                                for (const key in response.messages) {
                                    if (response.messages.hasOwnProperty(key)) {
                                        errorMessage += `${response.messages[key]}\n`;
                                    }
                                }
                            } else if (response.message) {
                                errorMessage = response.message;
                            } else {
                                errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                            }
                            alert(errorMessage);
                        } catch (e) {
                            console.error('Gagal parse response error:', e);
                            alert('Terjadi kesalahan saat memproses respons error.');
                        }
                    }
                });
            });
        }

        logout(); 

    })

</script>