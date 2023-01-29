@if($firmaContrato != null || $firmaContrato != '')
    @if($firmaContrato->firma != null || $firmaContrato->firma != '')
        @if($firmaContrato->video == null)
            <div class="col-md-12" id="nextStep">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a
                            type="button"
                            class="btn btn-warning pull-right"
                            href="{{ route('home.confirmar-documentos-adicionales', [$userIdHash, $firmaContratoHash, $moduloHash]) }}"
                            style="color: white;"
                        >
                            Siguiente paso <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endif