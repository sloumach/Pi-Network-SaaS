@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" integrity="sha512-Fm8kRNVGCBZn0sPmwJbVXlqfJmPC13zRsMElZenX6v721g/H7OukJd8XzDEBRQ2FSATK8xNF9UYvzsCtUpfeJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush
@section('content')
<div class="container ">
    <div class="row justify-content-center " style="margin-top:5%">


            <div class="col col-lg-8 col-md-8 col-sm-8 m-2 " align="center">
                <div class="card">
                    <div class="card-header">{{ __('Language article') }}</div>
                    <button class="btn btn-success" id="save-button" href="">save</button>

                    <div class="card-body">
                        <div class="my-editor" id="my-editor" placeholder="Your text as placeholder">
                            @if ($type == 'lang')
                            {{ $data->article }}</div>
                            @else
                            {{ $data->letter }}</div>
                            @endif

                    </div>
                </div>
        </div>


    </div>

</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" integrity="sha512-YJgZG+6o3xSc0k5wv774GS+W1gx0vuSI/kr0E0UylL/Qg/noNspPtYwHPN9q6n59CTR/uhgXfjDXLTRI+uIryg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{URL::asset('plugins/toastr/toastr.min.js')}}"></script>


<script>
$(document).ready(function() {
        $('#my-editor').trumbowyg({
            btns: [

                ['undo', 'redo'], // Only supported in Blink browsers



            ],
            plugins: {
            clipboard: true
            }

        });
        let id= "{{ $data_id }}"
        $('#save-button').click(function(event) {

            let cover=$('#my-editor').trumbowyg('html');
            let link = "{{ route('saveCover') }}";
            let type = "{{ $type }}";
            let token = $('meta[name="csrf-token"]').attr('content');
            if (type =='cover') {
                $.ajax({
                    url: link, // URL de votre route ou endpoint
                    method: 'POST', // Méthode de requête (POST, GET, etc.)
                    data: {
                        cover:cover,
                        type:type,
                        cover_id:id,
                        "_token": token


                    },
                    success: function(response) {
                        // Code à exécuter en cas de succès de la requête
                        console.log(response);
                        toastr.success('Article enregistré', {
                        timeOut: 5000
                        });

                    },
                    error: function(xhr, status, error) {
                        // Code à exécuter en cas d'erreur de la requête
                        console.log(error);
                        toastr.error('erreur d\'enregistrement', {
                        timeOut: 5000
                        });
                    }
                });
            } else {
                $.ajax({
                url: link, // URL de votre route ou endpoint
                method: 'POST', // Méthode de requête (POST, GET, etc.)
                data: {
                    cover:cover,
                    type:type,
                    cover_id:id,
                    "_token": token


                },
                success: function(response) {
                    // Code à exécuter en cas de succès de la requête
                    console.log(response);
                    toastr.success('Article enregistré', {
                    timeOut: 5000
                    });

                },
                error: function(xhr, status, error) {
                    // Code à exécuter en cas d'erreur de la requête
                    console.log(error);
                    toastr.error('erreur d\'enregistrement', {
                    timeOut: 5000
                    });
                }
            });
            }

        });

        var divElement = document.getElementById('my-editor');
        // Ajoutez un écouteur d'événements pour le clic droit (événement 'contextmenu')
        divElement.addEventListener('contextmenu', function(e) {
            // Empêchez le menu contextuel de s'ouvrir
            e.preventDefault();
            // Vous pouvez également afficher un message si vous le souhaitez

        }, false);
        document.getElementById('my-editor').addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'v') {  // Pour MacOS, utilisez e.metaKey au lieu de e.ctrlKey
            e.preventDefault();
        }
        }, false);
});
</script>
@endpush
