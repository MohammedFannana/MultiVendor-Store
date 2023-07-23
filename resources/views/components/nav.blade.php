  <!-- Sidebar Menu -->
  <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- $items from Nav.php in App -->
          @foreach($items as $item)
          <li class="nav-item">
              <!-- $active come from Nav.php in App/view -->
              <a href="{{ route($item['route'])}}" class="nav-link {{ Route::is($item['active'])? 'active' : ''}}">
                  <i class="{{$item['icon']}}"></i>
                  <p>
                      {{$item['title']}}

                      @if(isset($item['badge']))
                      <span class="right badge badge-danger">{{$item['badge']}}</span>
                      @endif
                  </p>
              </a>
          </li>
          @endforeach
      </ul>
  </nav>
  <!-- /.sidebar-menu -->