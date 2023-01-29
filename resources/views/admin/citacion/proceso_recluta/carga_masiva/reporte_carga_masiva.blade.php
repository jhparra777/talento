

<div class="container">
    <div class="row">
       
        <div class="table-responsive">
            <table class="table table-bordered">
              <tr>
                    @foreach( $headers as $key => $value )
                    <th class="active" >
                        {{$value}}
                    </th>
                    @endforeach
              </tr>
               
                    @foreach( $data as $field )
                    <tr>
                        <td >
                            {{$field["cedula"]}}
                        </td>
                        <td >
                            {{$field["registro"]}}
                        </td>
                        <td >
                            {{$field["asociacion"]}}
                        </td>
                        <td >
                            {{$field["req_id"]}}
                        </td>
                        <td >
                            @if($field["error"]!=null)
                  
                              @foreach($field["error"] as $error)
                                <div>-{{$error}}</div>
                              @endforeach
                            
                            @endif
                        </td>
                        
                      
                    </tr>
                    @endforeach

                 
            </table>
        </div>
    
    </div>
</div>


