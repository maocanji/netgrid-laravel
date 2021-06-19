<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" method="post" action="/">
                <div class="form-group">
                    <input type="text" placeholder="Busca Algo ..." class="form-control" name="top-search" id="top-search" />
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a class="dropdown-item" href="{{route('logout')}}" onclick="return logout(event);">
     <span class="text-danger">
        <i class="fa fa-fw fa-sign-out"></i>Salir
     </span>
                </a>

                <script type="text/javascript">
                    function logout(event){
                        event.preventDefault();
                        var check = confirm("Desea Salir... ?");
                        if(check){
                            document.getElementById('logout-form').submit();
                        }
                    }
                </script>



                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</div>
