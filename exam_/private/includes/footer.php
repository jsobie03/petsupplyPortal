<!-- jQuery first, then Bootstrap JS. -->
<script src="../../assets/js/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/jquery.1.12.4.js"></script>
<script src="../../assets/js/jquery.dataTables.min.js"></script>
<script src="../../assets/js/AmaranJS-master/dist/js/jquery.amaran.js"></script>
<script src="../../assets/js/particles.js-master/particles.js"></script>
<script src="../../assets/js/particles.js-master/parti.js"></script>
<script src="../../assets/js/my-login.js"></script>

<script>
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("myBtn").style.display = "block";
        } else {
            document.getElementById("myBtn").style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
</script>
<script>
    $(document).ready(function(){


    $('#example').DataTable({
        "order": [],
        "ordering": false,
     });


     $('#example2').DataTable({
        "order": [],
        "ordering": false,
     });

        var url = document.URL;
        // $(window).load(function(){
        //     if(url.includes("editexam")){
        //         $('#sidebarr').css('height','100vh');
        //     }
        // });

        $(window).load(function(){
            if(url.includes("index")){
                $('#body').css('background','#2a2a2a');
                // $('#body').css('overflow-y','hidden');
            }
        });

    var i = 0;
         $('#addQuestion').click(function(event){
            i++;
            $('#dynamic_field').append('<div id="row'+i+'"><a style="cursor:pointer; text-decoration:underline;" class="text-danger btn-outline-secondary col-sm-1 Remove_btn p-2 text-center rounded-0"  id="'+i+'">Remove</a><div class="card-block" id="row'+i+'"><br><textarea type="text" id="q" required class="form-control" name="question[]" placeholder="Your question here"></textarea><br><input id="a" type="text" required name="a[]" class="form-control" placeholder="Answer A :"><br><input id="b" type="text" required name="b[]" class="form-control" placeholder="Answer B :"><br><input  type="text" required name="c[]" class="form-control" id="c" placeholder="Answer C :"><br><input id="answerD" type="text" required name="d[]" class="form-control" placeholder="Answer D :"><br><label for="">&nbsp;Set Answer : </label><select  id="setAnswer" class="form-control" required name="correct_answer[]"><option value ="A">A</option><option value ="B">B</option><option value ="C">C</option><option value ="D">D</option></select></div>');

            if(i >= 10){
                $(this).off(event);
                $(this).attr('disabled','');
            }


        });

          $('#addSubject').click(function(event){
            i++;
             $('#dynamic_field_subject').append('<div id="row'+i+'"><a style="cursor:pointer; text-decoration:underline;" class="text-danger btn-outline-secondary col-sm-1 Remove_btn p-2 text-center rounded-0"  id="'+i+'">Remove</a><div class="card-block"><label for="#subject_name">Subject name : </label><input  type="text" id="subject_name" required name="subject_name[]" class="rounded-0 form-control" placeholder="Subject name"></div></div>');
            if(i >= 10){
                $(this).off(event);
                $(this).attr('disabled','');
            }
        });


         $(document).on('click','.Remove_btn',function(){
            var button_id = $(this).attr('id');
            $("#row"+button_id+"").remove();
         });

         $(document).on('click','#getQuestionInfo',function(){
            var question_id = $(this).attr('dir');
             $.ajax({
                    url:'../functions/func.php',
                    type:'POST',
                    data:{action:'getQuestionInfo',question_id:question_id},
                    dataType :'json',
                    success:function(result){
                       $('#question_id').val(result.question_id);
                       $('#question_desc').val(result.question_desc);
                       $('#answer_a').val(result.answer_a);
                       $('#answer_b').val(result.answer_b);
                       $('#answer_c').val(result.answer_c);
                       $('#answer_d').val(result.answer_d);
                       $('#exact_answer').val(result.exact_answer);
                    }
                })
         });

         $(document).on('click','#getSubjectInfo',function(){
            var subject_id = $(this).attr('dir');
             $.ajax({
                    url:'../functions/func.php',
                    type:'POST',
                    data:{action:'getSubjectInfo',subject_id:subject_id},
                    dataType :'json',
                    success:function(result){
                     $('#subject_id').val(result.subject_id);
                     $('#subject_name').val(result.subject_name);
                    }
                })
         });

         var question_id;
         $(document).on('click','#showModalDelete ',function(){
            question_id = $(this).attr('dir');
            $('#modal-2').modal('show');
         });

         $(document).on('submit','#deleteSelectQuestion',function(event){
            event.preventDefault();
            $.ajax({
                    url:'../functions/func.php?id=' + question_id,
                    type:'POST',
                    data:$(this).serialize(),
                    dataType :'html',
                    success:function(result){
                        $.amaran({
                            'theme'     :'awesome error',
                            'content'   :{
                                title:'Message',
                                message:'Question delete!',
                                info:'',
                                icon:'',
                            },
                            'position'  :'bottom right',
                            'outEffect' :'slideBottom'
                        });
                      $('#modal-2').modal('toggle');
                      $('#example').html(result);
                    },
                })
         });


         $(document).on('submit','#deleteSelectSubject',function(event){
            event.preventDefault();
            $.ajax({
                    url:'../functions/func.php?id=' + question_id,
                    type:'POST',
                    data:$(this).serialize(),
                    dataType :'html',
                    success:function(result){
                        $.amaran({
                            'theme'     :'awesome error',
                            'content'   :{
                                title:'Message',
                                message:'Question delete!',
                                info:'',
                                icon:'',
                            },
                            'position'  :'bottom right',
                            'outEffect' :'slideBottom'
                        });
                      $('#modal-2').modal('toggle');
                      $('#example').html(result);
                    },
                })
         });

         $(document).on('submit','#editQuestion',function(event){
            event.preventDefault();
             $.ajax({
                    url:'../functions/func.php',
                    type:'POST',
                    data:$(this).serialize(),
                    dataType :'html',
                    success:function(result){
                       $.amaran({
                            'message'         :'Successfully update question',
                            'cssanimationIn'    :'tada',
                            'cssanimationOut'   :'rollOut'
                         });
                      $('#editQuestion')[0].reset();
                      $('#modal-1').modal('toggle');
                      $('#example').html(result);
                    },
                })
         });

         $(document).on('submit','#editSubject',function(event){
            event.preventDefault();
             $.ajax({
                    url:'../functions/func.php',
                    type:'POST',
                    data:$(this).serialize(),
                    dataType :'html',
                    success:function(result){
                        $.amaran({
                            'message'         :'Successfully update subject',
                            'cssanimationIn'    :'tada',
                            'cssanimationOut'   :'rollOut'
                         });
                      $('#editSubject')[0].reset();
                      $('#modal-1').modal('toggle');
                      $('#example').html(result);
                    },
                })
         });


         $('#addQuestions').submit(function(e){
            e.preventDefault();
               $.ajax({
                    url:'../functions/func.php',
                    type:'POST',
                    data:$(this).serialize(),
                    dataType :'html',
                    success:function(result){
                        $.amaran({
                            'message'         :'Successfully add new question/questions',
                            'cssanimationIn'    :'tada',
                            'cssanimationOut'   :'rollOut'
                         });
                        $('#addQuestions')[0].reset();
                    },
                })
         });

          $('#createSubjects').submit(function(e){
            e.preventDefault();
               $.ajax({
                    url:'../functions/func.php',
                    type:'POST',
                    data:$(this).serialize(),
                    dataType :'html',
                    success:function(result){
                        $.amaran({
                            'message'         :'Successfully add new subject/subjects',
                            'cssanimationIn'    :'tada',
                            'cssanimationOut'   :'rollOut'
                         });
                      $('#createSubjects')[0].reset();
                    },
                })
         });

    $(document).on('click','#nextQuestion',function(event){
        event.preventDefault();
        var id = $(this).attr('dir');
        var radio_buttons = $('input[name="choices"]');
        if(radio_buttons.is(":checked")){
            var select = $('input[name="choices"]:checked').val();
            var letter_select = $('input[name="choices"]:checked').attr('dir');
            var question_id = $(this).attr('data-id-type');
             $.ajax({
                url:'../functions/func.php',
                type:'POST',
                data:{action:'checkAnswer',data:id,answer:select,letter:letter_select,question:question_id},
                dataType :'html',
                success:function(result){
                    location.reload();
                }
             });
        }else{
             $.amaran({
                'message'         :'You can skip if you don\'t know the answer',
                'cssanimationIn'    :'tada',
                'cssanimationOut'   :'rollOut'
             });
        }

    });

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
                         minlength: 5,
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
                        required: " is required",
                        minlength: "enter at least 5 characters"
                    },

                    password:{
                        required: "is required",
                        minlength: "enter at least 8 characters",
                    },

                    password2:{
                        required: " is required",
                        minlength: "enter at least 8 characters",
                        equalTo:" not match",
                    },

                    firstname:{
                        required: " is required",
                        minlength: "enter at least 5 characters"
                    },

                    middlename:{
                        required: " is required",
                        minlength: "enter at least 2 characters"
                    },

                    lastname:{
                        required: " is required",
                        minlength: "enter at least 2 characters"
                    },

                    birthday:{
                        required: "Birthday is required",
                    },

                },
                highlight: function(element) {
                  var elementId = $(element).attr('id');
                  $('#' + elementId).parent().addClass('has-danger');
                  $('#' + elementId).parent().find('label').css('color','red');
                  $('#' + elementId).addClass('form-control-danger');
                },
                unhighlight: function(element) {
                  var elementId = $(element).attr('id');
                  $('#' + elementId).parent().removeClass('has-danger').addClass('has-success');
                  $('#' + elementId).removeClass('form-control-danger').addClass('form-control-success');
                  $('#' + elementId).parent().find('label').css('color','green');
                },
                errorPlacement: function(error, element) {
                  var placement = $(element).data('error');
                  if (placement) {
                    $(placement).append(error);
                  } else {
                    error.insertBefore(element).css('color','red');
                  }
                },

            });
     });

        $('#sub_name').change(function(){
          // var filter_value =
          $.ajax({
               url:'../functions/func.php',
                type:'POST',
                data:{action:'checkAnswer',data:id,answer:select,letter:letter_select,question:question_id},
                dataType :'html',
                success:function(result){
                    location.reload();
                }
          });
        });
    });
</script>


<script src="../../assets/js/bootstrap.min.js"></script>
<script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/js/dist/jquery.validate.min.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>