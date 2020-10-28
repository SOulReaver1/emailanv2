<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('index') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png"  class="img-fluid" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Mon profil') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Paramètres') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Deconnexion') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.create')}}">
                        <i class="fas fa-users text-warning"></i>
                        <span class="nav-link-text">{{ __('Gestion des      utilisateurs') }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-fais" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-fais">
                        <i class="fas fa-wifi text-blue"></i>
                        <span class="nav-link-text">{{ __("Fai's") }}</span>
                    </a>

                    <div class="collapse" id="navbar-fais">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('fais.index')}}">
                                    {{ __('Liste des FAIS') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('fais.create')}}">
                                    {{ __('Créer un FAI') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-addressees" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-addressees">
                        <i class="fas fa-envelope text-red"></i>
                        <span class="nav-link-text">{{ __("Les bases") }}</span>
                    </a>

                    <div class="collapse show" id="navbar-addressees">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('index')}}">
                                    {{ __('Liste des bases') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('create')}}">
                                    {{ __('Importer une base') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('bases.create')}}">
                                    {{ __('Créer une base') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-repoussoir" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-addressees">
                        <i class="fas fa-file-alt text-green"></i>
                        <span class="nav-link-text">{{ __("Repoussoir") }}</span>
                    </a>

                    <div class="collapse" id="navbar-repoussoir">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('encrypt.index')}}">
                                    {{ __('Liste des repoussoirs') }} 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('encrypt.create')}}">
                                    {{ __('Convertir une liste') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#navbar-tags" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-tags">
                        <i class="fas fa-tags text-orange"></i>
                        <span class="nav-link-text">{{ __("Tags") }}</span>
                    </a>
                    <div class="collapse" id="navbar-tags">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('tags.create')}}">
                                    {{ __('Importer des tags') }}
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{route('tags.sync')}}">
                                    {{ __('Synchroniser les tags') }}
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('tags.destroy')}}">
                                    {{ __('Supprimer des tags') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-comparateur" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-comparateur">
                        <i class="fas fa-not-equal text-teal"></i>
                        <span class="nav-link-text">{{ __("Comparateur") }}</span>
                    </a>
                    <div class="collapse" id="navbar-comparateur">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('comparator.index')}}">
                                    {{ __('Liste des comparaisons') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse" id="navbar-comparateur">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('comparator.create')}}">
                                    {{ __('Créer une comparaison') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('export') }}">
                      <i class="fas fa-file-export" style="color: #CCCC00;"></i>
                      <span class="nav-link-text">Exportation de base</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cut') }}">
                      <i class="fas fa-cut" style="color: pink;"></i>
                      <span class="nav-link-text">Découper sur base</span>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>
