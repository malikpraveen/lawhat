
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/admin/images/favicon.png')}}">
        <title>lawhat : Admin Panel</title> 
        <meta name="keywords" content="Meen." />
        <meta name="author" content="Meen" />
        <link href="https://www.meen.com.com/admin" rel="canonical" />
        <meta name="Classification" content="meen" />
        <meta name="abstract" content="https://www.meen.com/admin" />
        <meta name="audience" content="All" />
        <meta name="robots" content="index,follow" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:title" content="Meen Admin Panel" /> 
        <meta property="og:url" content="https://www.meen.com/admin" /> 
        <meta property="og:site_name" content="meen" />
        <meta name="googlebot" content="index,follow" />
        <meta name="distribution" content="Global" />
        <meta name="Language" content="en-us" />
        <meta name="doc-type" content="Public" />
        <meta name="site_name" content="meen" />
        <meta name="url" content="https://www.meen.com/admin" />
        <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('assets/admin/css/et-line-font/et-line-font.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/themify-icons/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/simple-lineicon/simple-line-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables/css/dataTables.bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/skins/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/plugins/formwizard/jquery-steps.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/plugins/dropify/dropify.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/font/stylesheet.css')}}">
        <style>
            .loader {
                text-align: center;
                vertical-align: middle;
                position: fixed;
                display: flex;
                background: #fdfbfb;
                padding: 150px;
                box-shadow: 0px 40px 60px -20px rgba(0, 0, 0, 0.2);
                width:100%;
                z-index:500000;
                height: 100%;
                padding-left: 43%;
                padding-top: 30%;
            }

            .loader span {
                display: block;
                width: 20px;
                height: 20px;
                background: #ec1d38;
                border-radius: 50%;
                margin: 0 5px;
                margin-top: 85px;
                box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
            }


            .loader span:nth-child(2) {
                background: #f07e6e;
            }

            .loader span:nth-child(3) {
                background: #84cdfa;
            }

            .loader span:nth-child(4) {
                background: #5ad1cd;
            }

            .loader span:not(:last-child) {
                animation: animate 1.5s linear infinite;
            }

            @keyframes animate {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(30px);
                }
            }

            .loader span:last-child {
                animation: jump 1.5s ease-in-out infinite;
            }

            @keyframes jump {
                0% {
                    transform: translate(0, 0);
                }
                10% {
                    transform: translate(10px, -10px);
                }
                20% {
                    transform: translate(20px, 10px);
                }
                30% {
                    transform: translate(30px, -50px);
                }
                70% {
                    transform: translate(-150px, -50px);
                }
                80% {
                    transform: translate(-140px, 10px);
                }
                90% {
                    transform: translate(-130px, -10px);
                }
                100% {
                    transform: translate(-120px, 0);
                }
            }


            .loaderDiv{
                position: fixed;
    z-index: 5000000000001;
    text-align: center;
    top: 40%;
    left: 40%;
            }

            .loaderDiv p{
                color:#ec1d38!important;
            }
        </style>
    </head>
    <body class="skin-blue sidebar-mini">
        <div class="loading loaderDiv">
            <img class="mb-2" style="width: 40%;" src="{{asset('assets/admin/images/logo.png')}}" alt="logo">
            <p>Please wait while page is loading..</p>
        </div>
        <div class="loading loader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="wrapper boxed-wrapper">

            <!-- Navbar -->
            @include('admin.layout.header')
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            <!-- <div class="dashboard-section"> -->
            @include('admin.layout.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <!-- <div class="content-wrapper"> -->
            <!-- <div id="loader" class="lds-dual-ring hidden overlay"></div> -->
            <!-- Content Header (Page header) -->
            @yield('content')
            <!-- /.content-header -->
            <!-- </div> -->
            <!-- Main Footer -->
            @include('admin.layout.footer')
            <!-- </div> -->
            <!-- /.content-wrapper -->

        </div>

        <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
        <script src="{{asset('assets/admin/js/bizadmin.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/jquery-sparklines/jquery.sparkline.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/jquery-sparklines/sparkline-int.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/raphael/raphael-min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/morris/morris.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/functions/dashboard1.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/admin/js/demo.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/formwizard/jquery-steps.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/dropify/dropify.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/chartjs/chart.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/chartjs/chart-int.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script> 
        <script src="{{asset('assets/admin/plugins/dropzone-master/dropzone.js')}}"></script> 
        <script src="{{asset('assets/admin/js/chosen.jquery.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/admin/js/chosenImage.jquery.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            $(".chosen").chosen();
        </script>
        <script>
            $(".my-select").chosenImage({
                disable_search_threshold: 10
            });
        </script>
        <script type="text/javascript">
            var $loading = $('.loading').hide();
            $(document)
                    .ajaxStart(function () {
                        //ajax request went so show the loading image
                        $loading.show();
                    })
                    .ajaxStop(function () {
                        //got response so hide the loading image
                        $loading.hide();

                    });

            $(document).ready(function () {
                $('#example-getting-started').multiselect({
                    numberDisplayed: 1,
                    includeSelectAllOption: true,
                    allSelectedText: 'All Topics selected',
                    nonSelectedText: 'No Topics selected',
                    selectAllValue: 'all',
                    selectAllText: 'Select all',
                    unselectAllText: 'Unselect all',
                    onSelectAll: function (checked) {
                        var all = $('#example-getting-started ~ .btn-group .dropdown-menu .multiselect-all .checkbox');
                        all
                                // get all child nodes including text and comment
                                .contents()
                                // iterate and filter out elements
                                .filter(function () {
                                    // check node is text and non-empty
                                    return this.nodeType === 3 && this.textContent.trim().length;
                                    // replace it with new text
                                }).replaceWith(checked ? this.unselectAllText : this.selectAllText);
                    },
                    onChange: function () {
                        debugger;
                        var select = $(this.$select[0]);
                        var dropdown = $(this.$ul[0]);
                        var options = select.find('option').length;
                        var selected = select.find('option:selected').length;
                        var all = dropdown.find('.multiselect-all .checkbox');
                        all
                                // get all child nodes including text and comment
                                .contents()
                                // iterate and filter out elements
                                .filter(function () {
                                    // check node is text and non-empty
                                    return this.nodeType === 3 && this.textContent.trim().length;
                                    // replace it with new text
                                }).replaceWith(options === selected ? this.options.unselectAllText : this.options.selectAllText);
                    }
                });

                $("#form").submit(function (e) {
                    e.preventDefault();
                    alert($(this).serialize());
                });
            });


        </script>
        <script>
            $(function () {
                $('#example1').DataTable()
                $('#example2').DataTable()
                $('#example3').DataTable({
                    'paging': true,
                    'lengthChange': false,
                    'searching': false,
                    'ordering': true,
                    'info': true,
                    'autoWidth': false
                })
            })
        </script>
        <script>
            var frmRes = $('#frmRes');
            var frmResValidator = frmRes.validate();

            var frmInfo = $('#frmInfo');
            var frmInfoValidator = frmInfo.validate();

            var frmLogin = $('#frmLogin');
            var frmLoginValidator = frmLogin.validate();

            var frmMobile = $('#frmMobile');
            var frmMobileValidator = frmMobile.validate();

            $('#demo1').steps({
                onChange: function (currentIndex, newIndex, stepDirection) {
                    console.log('onChange', currentIndex, newIndex, stepDirection);
                    // tab1
                    if (currentIndex === 0) {
                        if (stepDirection === 'forward') {
                            var valid = frmRes.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmResValidator.resetForm();
                        }
                    }

                    // tab2
                    if (currentIndex === 1) {
                        if (stepDirection === 'forward') {
                            var valid = frmInfo.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmInfoValidator.resetForm();
                        }
                    }

                    // tab3
                    if (currentIndex === 2) {
                        if (stepDirection === 'forward') {
                            var valid = frmLogin.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmLoginValidator.resetForm();
                        }
                    }

                    // tab4
                    if (currentIndex === 3) {
                        if (stepDirection === 'forward') {
                            var valid = frmMobile.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmMobileValidator.resetForm();
                        }
                    }

                    return true;

                },
                onFinish: function () {
                    alert('Wizard Completed');
                }
            });
        </script> 
        <script>
            $('#demo').steps({
                onFinish: function () {
                    alert('Wizard Completed');
                }
            });
        </script>
        <script>
            $(document).ready(function () {
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove: 'Supprimer',
                        error: 'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function (event, element) {
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function (event, element) {
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function (event, element) {
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function (e) {
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        </script>
        <script>
            $(function () {
                //Add text editor
                $("#compose-textarea").wysihtml5();
            });
        </script>
        <!-- <script>
            var imgflag = true;
            $(document).ready(function () {

                $(".alphanum").keypress(function (e) {
                    var specialKeys = new Array();
                    specialKeys.push(8); //Backspace
                    specialKeys.push(9); //Tab
                    specialKeys.push(46); //Delete
                    specialKeys.push(36); //Home
                    specialKeys.push(35); //End
                    specialKeys.push(37); //Left
                    specialKeys.push(39); //Right
                    var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
                    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode == 124) || (keyCode == 58) || (keyCode >= 37 && keyCode <= 46) || (keyCode == 32) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));

                    if (ret == true) {
                        return true;
                    } else {
                        e.preventDefault();
                        return false;
                    }

                });

                // $('.arabicinput').keyup(function(e){
                //      var specialKeys = new Array();
                //     specialKeys.push(8); //Backspace
                //     specialKeys.push(9); //Tab
                //     specialKeys.push(46); //Delete
                //     specialKeys.push(36); //Home
                //     specialKeys.push(35); //End
                //     specialKeys.push(37); //Left
                //     specialKeys.push(39); //Right
                //     // var unicode=e.charCode? e.charCode : e.keyCode
                //     var unicode = e.keyCode == 0 ? e.charCode : e.keyCode;

                //     var ret=(( unicode<48 || unicode>57) || (unicode < 0x0600 || unicode > 0x06FF) || (unicode == 124) || (unicode == 58) || (unicode >= 37 && unicode <= 46) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
                //         alert(ret);
                //         if (ret){
                //             return true;
                //         } else{
                //             e.preventDefault();
                //             return false;
                //         }
                // });
            });

            function checkPrice(element) {
                if (isNaN(element.val())) {
                    return false;
                } else {
                    return true;
                }
            }

            function validImage(obj, wi, hi) {
                var _URL = window.URL || window.webkitURL;
                var file = $(obj).prop('files')[0];
                var img = new Image();
                var min_wi = parseInt(wi) - 50;

                img.onload = function () {
                    var wid = this.width;
                    var ht = this.height;
                    if ((wid < min_wi || wid > wi) || ht !== hi) {
                        imgflag = false;
                    } else {
                        imgflag = true;
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        </script> -->
        <!-- <script>
            var langArray = [];
            $('.vodiapicker option').each(function () {
                var img = $(this).attr("data-thumbnail");
                var text = this.innerText;
                var value = $(this).val();
                var dis = $(this).attr("disabled");
                if (dis == "disabled") {
                    var item = '<li><span style="margin-left:15px;">' + text + '</span></li>';
                } else {
                    var item = '<li><img src="' + img + '" alt="" value="' + value + '"/><span>' + text + '</span></li>';

                }
                langArray.push(item);
            })

            $('#a').html(langArray);
            //Set the button value to the first el of the array
            $('.btn-select').html(langArray[0]);
            $('.btn-select').attr('value', '');
            //change button stuff on click
            $('#a li').click(function () {
                var img = $(this).find('img').attr("src");
                var value = $(this).find('img').attr('value');
                var text = this.innerText;
                var dis = this.innerText;
                if (dis == "Select Country") {
                    var item = '<li><span>' + text + '</span></li>';
                    $('.btn-select').attr('value', "");
                } else {
                    var item = '<li><img src="' + img + '" alt="" /><span>' + text + '</span></li>';
                    $('.btn-select').attr('value', value);
                }
                $('.btn-select').html(item);
                $("#country").prop("selectedIndex", text);
                $(".b").toggle();
                //console.log(value);
            });
            $(".btn-select").click(function () {
                $(".b").toggle();
            });
            //check local storage for the lang
            var sessionLang = localStorage.getItem('lang');
            if (sessionLang) {
                //find an item with value of sessionLang
                var langIndex = langArray.indexOf(sessionLang);
                $('.btn-select').html(langArray[langIndex]);
                $('.btn-select').attr('value', sessionLang);
            } else {
                var langIndex = langArray.indexOf('ch');
                console.log(langIndex);
                $('.btn-select').html(langArray[langIndex]);
                //$('.btn-select').attr('value', 'en');
            }



        </script> -->
    </body>
</html>