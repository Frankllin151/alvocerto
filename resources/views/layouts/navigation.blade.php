


<style>
    .page {
            display: none;
            animation: fadeIn 0.3s ease-in;
        }
        .page.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .nav-item.active {
            background-color: rgb(59 130 246);
            color: white;
        }
</style>

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-2xl font-bold">
                    <a href="{{route("dashboard")}}">Dashboard</a>
                </h1>
                <p class="text-gray-400 text-sm">Sistema ICP</p>
            </div>
            
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{route("dashboard")}}" class="nav-item 
                        {{Route::currentRouteName() == 'dashboard' ? 'active' : ''}}
                        flex items-center gap-3 p-3 rounded-lg hover:bg-gray-800 transition" data-page="home">
                            
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Início</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route("nichos.index")}}" class="nav-item 
                        {{Route::currentRouteName() == 'nichos.index' ? 'active' : ''}}
                         flex items-center gap-3 p-3 rounded-lg hover:bg-gray-800 transition" data-page="analytics">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
    d="M4 4h7v7H4V4zm9 0h7v7h-7V4zM4 13h7v7H4v-7zm9 0h7v7h-7v-7z" />
</svg>
<span>Nichos</span>
                        </a>
                    </li>

                     <li>
                        <a href="{{route("estagio.de.contato.index")}}" class="nav-item 
                        {{Route::currentRouteName() == 'estagio.de.contato.index' ? 'active' : ''}}
                         flex items-center gap-3 p-3 rounded-lg hover:bg-gray-800 transition" data-page="analytics">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
    d="M4 4h7v7H4V4zm9 0h7v7h-7V4zM4 13h7v7H4v-7zm9 0h7v7h-7v-7z" />
</svg>
<span>Estágio de Contato</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{route("profile.edit")}}" class="
                        {{Route::currentRouteName() == 'profile.edit' ? 'active' : ''}}
                        nav-item flex items-center gap-3 p-3 rounded-lg hover:bg-gray-800 transition" data-page="settings">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Configurações</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                        <span class="text-sm font-semibold">
                             {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                    </div>
                  <div>
    <p class="text-sm font-medium">
        {{ Auth::user()->name }}
    </p>
</div>

                </div>
            </div>
        </aside>

      


   