@if($firmaContrato != null && isset($reqcandidato->token_acceso) )
    <footer> 
        <div style="position: relative;">
            IP: {{ $firmaContrato->ip }}
            &nbsp;
            Token de acceso: {{ $reqcandidato->token_acceso }}
        </div>
    </footer>
                    
@endif
