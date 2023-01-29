<style>
	/*Button success*/
	.btn-success { color: #fff; background-color: {{ $sitio_informacion->color }}; border-color: {{ $sitio_informacion->color }}; }

	.btn-success[disabled] { background-color: {{ $sitio_informacion->color }}; border-color: {{ $sitio_informacion->color }}; }
	.btn-success:focus[disabled] { background-color: {{ $sitio_informacion->color }}; border-color: {{ $sitio_informacion->color }}; }
	.btn-success:hover { background-color: {{ $sitio_informacion->color }}; border-color: {{ $sitio_informacion->color }}; }
	.btn-success:focus { background-color: {{ $sitio_informacion->color }}; border-color: {{ $sitio_informacion->color }}; }

	/*Form control*/
	.form-control:focus {
	    border-color: {{ $sitio_informacion->color }};
	    outline: 0 none;
	    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px white;
	    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px white;
	}

	/*Float button*/
	.show {
	  display: block;
	}
	.hide {
	  display: none;
	}

	#floating-container {
	    position: fixed;
	    width: 70px;
	    height: 70px;
	    bottom: 10px;
	    right: 20px;
	    z-index: 50;
	}

	#floating-container .floating-menus > div {
	    position: fixed;
	    right: 50px;
	}

	#floating-container .floating-menus > div a {
	    background-color: {{ $sitio_informacion->color }};
	    color: #fff;
	    padding: 5px 10px;
	    border-radius: 5px;
	    box-shadow: 0px 1px 2px #B0BEC5;
	}

	#floating-container .floating-menus > div a:hover {
	    text-decoration: none;
	}

	#floating-container .floating-menus > div:nth-of-type(1){
	    bottom: 90px;
	    animation: crearconf 0.1s linear;
	}

	#floating-container .floating-menus > div:nth-of-type(2){
	  	bottom: 125px;
	  	animation: previsualizar 0.125s linear;
	}

	#floating-container .fab-button {
	    position: absolute;
	    color: #fff;
	    padding: 20px 25px;
	    border-radius: 50%;
	    background-color: {{ $sitio_informacion->color }};
	    cursor: pointer;
	    box-shadow:0px 3px 3px #BDBDBD;
	}

	@keyframes crearconf {
	    from {bottom:80px;}
	    to {bottom: 90px;}
	}

	@keyframes previsualizar {
	  from {bottom:80px;}
	  to {bottom: 125px;}
	}
</style>