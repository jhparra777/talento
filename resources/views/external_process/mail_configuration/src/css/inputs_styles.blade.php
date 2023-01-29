<style>
	/*File*/
	.file-button {
		float: left;
		height: 3rem;
		line-height: 3rem;
		text-decoration: none;
		color: #fff;
		background-color: {{ $sitio_informacion->color }};
		text-align: center;
		letter-spacing: .5px;
		transition: background-color .2s ease-out;
		cursor: pointer;
		border: none;
		border-radius: 2px;
		display: inline-block;
		height: 36px;
		line-height: 36px;
		padding: 0 16px;
		text-transform: uppercase;
		vertical-align: middle;
	}

	.file-button span {
		cursor: pointer;
	}

	.file-button input[type="file"] {
		position: absolute;
		top: 0;
		right: 0;
		left: 0;
		bottom: 0;
		width: 100%;
		margin: 0;
		padding: 0;
		font-size: 20px;
		cursor: pointer;
		opacity: 0;
	}

	.file-path-wrapper {
		overflow: hidden;
		padding-left: 10px;
	}

	.file-path-wrapper output {
		border-bottom: 1px solid {{ $sitio_informacion->color }};
		box-shadow: 0 1px 0 0 {{ $sitio_informacion->color }};
		width:100%;
		background-color: transparent;
		border-radius: 0;
		outline: none;
		height: 3rem;
		width: 100%;
		font-size: 16px;
		margin: 0 0 8px 0;
		padding: 0;
	}

	.file-path-wrapper .helper-text{
		min-height: 18px;
		display: block;
		font-size: 12px;
		color: rgba(0,0,0,0.54);
	}

	.msg-wrapper{
		padding: 1rem;
		background: #F44336;
		color: #fafafa; 
		display: none;
	}

	.msg{
		font-weight: bold;
		font: sans-serif;
	}

	.input-field {
		position: relative;
		margin-top: 1rem;
		margin-bottom: 1rem;
		float: left;
		box-sizing: border-box;
		padding: 0 .75rem;
		min-height: 1px;
	}

	/*Toggle*/
	.toggle {
        --width: 50px;
        --height: calc(var(--width) / 2);
        --border-radius: calc(var(--height) / 2);

        display: inline-block;
        cursor: pointer;
    }

    .toggle__input { display: none; }

    .toggle__fill {
        position: relative;
        width: var(--width);
        height: var(--height);
        border-radius: var(--border-radius);
        background: #dddddd;
        transition: background 0.2s;
    }

    .toggle__input:checked ~ .toggle__fill { background: #008d4c; }
    .toggle__input:checked ~ .toggle__fill_fb { background: #4267B2; }
    .toggle__input:checked ~ .toggle__fill_tw { background: #00acee; }
    .toggle__input:checked ~ .toggle__fill_ln { background: #0072b1; }
    .toggle__input:checked ~ .toggle__fill_in { background: #bc2a8d; }
    .toggle__input:checked ~ .toggle__fill_wp { background: #25d366; }

    .toggle__fill::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: var(--height);
        width: var(--height);
        background: #ffffff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
        border-radius: var(--border-radius);
        transition: transform 0.2s;
    }

    .toggle__input:checked ~ .toggle__fill::after { transform: translateX(var(--height)); }
</style>