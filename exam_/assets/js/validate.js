   $(function () {
        $.validator.setDefaults({
            submitHandler: function() {
                alert("submitted!");
            }
        });           
        $('#changeProfile').validate({
                rules: {

                    username: {
                         required: true,
                         minlength: 8,
                    },

                    password:{
                         required: true,
                         minlength: 8,
                    },

                    password2:{
                         required:true,
                         minlength:8,
                         equalTo: "#password"
                    },

                    firstname: {
                         required: true,
                         minlength: 5,
                    },

                    middlename:{
                        required :true,
                        minlength :2,
                    },

                    lastname:{
                        required :true,
                        minlength :2,
                    },

                    birthday:{
                        required :true,
                    },
                   
                },
                //For custom messages
                messages: {
                    username:{
                        required: "Username is required",
                        minlength: "Enter at least 5 characters"
                    },

                    password:{
                        required: "Password is required",
                        minlength: "Enter at least 8 characters",
                    },

                    password2:{
                        required: "Retype password is required",
                        minlength: "Enter at least 8 characters",
                        equalTo:"Password not match",
                    },

                    firstname:{
                        required: "Firstname is required",
                        minlength: "Enter at least 5 characters"
                    },

                    middlename:{
                        required: "Middlename is required",
                        minlength: "Enter at least 2 characters"
                    },

                    lastname:{
                        required: "Lastname is required",
                        minlength: "Enter at least 2 characters"
                    },

                    birthday:{
                        required: "Birthday is required",
                    },

                },
                errorElement : 'span',
                errorPlacement: function(error, element) {
                  var placement = $(element).data('error');
                  if (placement) {
                    $(placement).append(error);
                  } else {
                    error.insertAfter(element).css('color','red');
                  }
                }
            });
     });