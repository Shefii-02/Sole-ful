<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Soleful | Admin Dashboard
    </title>
    <meta name="csrf-token" content="{csrf_token()}">
    <link rel="icon" type="image/x-icon" href="/assets/img/logo/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet">

    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('header')
</head>

<body x-data="{ page: 'crm', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark text-bodydark bg-boxdark-2': darkMode === true }">
    <!-- ===== Preloader Start ===== -->
    <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-primary border-t-transparent">
        </div>
    </div>

    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')
        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            @include('admin.layouts.header')
            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="mx-auto max-w-screen-2xll p-4 md:p-6 2xl:p-10">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>


    <script defer src="{{ asset('assets/admin/bundle.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/egk3pv0g39y6uwv2sqomir21e7x8okqvr2cvt13d4pngampx/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>


    <script>
        tinymce.init({
            selector: '.tinyeditor',
            setup: function(editor) {
                editor.on('input', function() {
                    tinymce.triggerSave(); // Updates the linked textarea
                    console.log('Content saved to the textarea:', editor.getContent());
                });
            },
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists',
                'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',

            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                }
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                'See docs to implement AI Assistant')),
        });
    </script>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-slick]').slick();
        });
    </script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right", // Toast position
            "timeOut": "5000", // Timeout duration
            "extendedTimeOut": "5000",
        };

        @if (session('success_msg'))
            toastr.success("{{ session('success_msg') }}", "Success");
        @elseif (session('failed_msg'))
            toastr.error("{{ session('failed_msg') }}", "Error");
        @elseif (session('info'))
            toastr.info("{{ session('info') }}", "Info");
        @elseif (session('warning'))
            toastr.warning("{{ session('warning') }}", "Warning");
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        function confirmDelete(bannerId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById('form_' + bannerId).submit();
                }
            });
        }
    </script>
    <script>
        function imageHandler(initialUrl) {
            return {
                image: null,
                imageUrl: initialUrl || '',
                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Validate file size (100KB = 102400 bytes)
                        const maxSize = 1024 * 100; // 100KB in bytes
                        if (file.size > maxSize) {
                            alert('File size must not exceed 100KB. Please choose a smaller file.');
                            event.target.value = ''; // Reset the file input
                            return;
                        }
                        this.image = file;
                        this.imageUrl = URL.createObjectURL(file);
                    }
                },
                removeImage() {
                    this.image = null;
                    this.imageUrl = '';
                    this.$refs.fileInput.value = ''; // Reset the file input
                }
            };
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            });
        </script>
    @endif

    @stack('footer')

</body>

</html>
