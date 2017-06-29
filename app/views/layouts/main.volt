<nav class="navbar navbar-default navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">{{ image("img/logo_pascual.png", "alt": "Interventoría Buen Comienzo") }} <span class="caret"></span></a>
			<div class="dropdown-menu list-group" role="menu">
				{{ elements.getMenuInicio() }}
			</div>
        </div>
        {{ elements.getMenu() }}
    </div>
</nav>
<div class="container">
    {{ flash.output() }}
    {{ content() }}
    <hr>
    <footer>
    	<p>Interventoría Buen Comienzo<br>Calle 52 (av. La Playa) # 49-27, edificio Santa Elena piso 14, Medellín (Antioquia)<br>Horario: lunes a viernes 8:00 am - 11:45 am; 1:30 pm - 4:30 pm<br> PBX: (4) 5121233. Email: info@interventoriabuencomienzo.org</p>
    </footer>
</div>
