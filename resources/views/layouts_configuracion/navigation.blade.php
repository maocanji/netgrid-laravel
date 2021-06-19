 <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_small.jpg" />
                             </span>


                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">Usuario :</strong>
                                </span>
                                <span class="text-muted text-xs block">
                                  Usuario  {!! Auth::user()->name !!}
                                    <b class="caret"></b>
                                </span>
                            </span>
                            </a>



                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="Mi perfil">Perfil</a></li>
                            <li><a href="usuarios">Contactos</a></li>
                            <li class="divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        Banca
                    </div>
                </li>

                <li id="Dashboard" name="Dashboard">
                    <a href="home"><i class="fa fa-desktop"></i> <span class="nav-label">Dashboard</span></a>
                </li>

                <li id="200" name="admin_user">
                    <a href="admin_user"><i class="fa fa-desktop"></i> <span class="nav-label">Usuarios Admin</span></a>
                </li>


                <li id="300" name="300">
                    <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">Menu </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li id="310" name="310">
                            <a href="todos_user">Usuarios</a>
                        </li>
                        <li id="320" name="320">
                            <a href="comentarios">Comentarios</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
