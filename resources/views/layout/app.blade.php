<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NoteApp - laravel 11</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset("plugins/tinymce/tinymce.min.js") }}"></script>
    <script>
        tinymce.init({
            selector: '.tinymce6',
            height: 500,
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount imagetools media code',
            toolbar: 'undo redo | styles | formatselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image table media code | removeformat | help',
            branding: false,

            // Enable automatic image upload
            images_upload_url: '{{ route('upload.image') }}',
            automatic_uploads: true,
            image_advtab: true,
            image_caption: true,
            image_title: true,

            // Additional image styling options
            image_class_list: [{
                    title: 'None',
                    value: ''
                },
                {
                    title: 'Responsive',
                    value: 'img-fluid'
                },
                {
                    title: 'Rounded',
                    value: 'rounded'
                },
                {
                    title: 'Bordered',
                    value: 'border'
                },
                {
                    title: 'Shadow',
                    value: 'shadow'
                }
            ],

            // Table enhancements
            table_advtab: true,
            table_default_styles: {
                width: '100%',
                borderCollapse: 'collapse'
            },
            table_class_list: [{
                    title: 'None',
                    value: ''
                },
                {
                    title: 'Striped',
                    value: 'table-striped'
                },
                {
                    title: 'Bordered',
                    value: 'table-bordered'
                },
                {
                    title: 'Hover',
                    value: 'table-hover'
                }
            ],

            // Allow inserting media (videos, audio, iframe embeds)
            media_live_embeds: true,

            // Allow code formatting
            code_dialog_width: 600,

            // Handle image selection from local files
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    let input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function() {
                        let file = this.files[0];
                        let formData = new FormData();
                        formData.append('file', file);

                        fetch('{{ route('upload.image') }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                callback(data.location);
                            })
                            .catch(error => console.error('Error:', error));
                    };
                    input.click();
                }
            },
            setup: function(editor) {
                let previousImages = [];

                editor.on('init', function() {
                    updateImageList();
                });

                editor.on('NodeChange', function() {
                    updateImageList();
                });

                function updateImageList() {
                    let content = editor.getContent();
                    let usedImages = [];

                    // Extract image sources from the content
                    content.replace(/<img[^>]+src="([^">]+)"/g, function(match, src) {
                        usedImages.push(src);
                    });

                    // Find images that were removed
                    let removedImages = previousImages.filter(img => !usedImages.includes(img));

                    if (removedImages.length > 0) {
                        // Send a request to clean up only the removed images
                        fetch('{{ route('cleanup.images') }}', {
                            method: 'POST',
                            body: JSON.stringify({
                                removed_images: removedImages
                            }),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        });
                    }

                    // Update previousImages list
                    previousImages = usedImages;
                }
            }
        });
    </script>




    @yield('customJS')
</body>

</html>
