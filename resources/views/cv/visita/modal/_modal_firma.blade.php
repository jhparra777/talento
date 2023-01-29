<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Firma</h3>
            </div>

            <div class="modal-body" style="overflow:auto;">
                <div id="texto">
                    <p>Por favor dibuja tu firma en el panel blanco usando tu mouse o usa tu dedo si estás desde un dispositivo móvil</p>

                    {!! Form::hidden("id", null, ["id" => "fr_id"]) !!}

                    <table class="col-md-12 col-xs-12 col-sm-12 center table" bgcolor="#f1f1f1">
                        <tr>
                            <td width="10%"></td>
                            <td>
                                <div>
                                    <div>
                                        <div id="firmBoard" style="width: 400px; height: 160px; margin: 1rem;"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success guardarFirma" disabled>Firmar</button>
            </div>
        </div>
    </div>
</div>