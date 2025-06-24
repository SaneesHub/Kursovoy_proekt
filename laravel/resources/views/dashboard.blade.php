@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        @php
            $user = Auth::user();
        @endphp
        
        @if ($user->id_role == 1)
            <div class="admin-panel mb-8">
                <h3 class="section-title">Административные отчёты</h3>
                <div class="button-group">
                    <a href="{{ route('admin.reports.network') }}" class="btn-report btn-equipment">
                        <i class="fas fa-network-wired mr-2"></i>Оборудование и ошибки
                    </a>
                    <a href="{{ route('admin.reports.services') }}" class="btn-report btn-services">
                        <i class="fas fa-wifi mr-2"></i>Подключённые услуги
                    </a>
                    <a href="{{ route('admin.reports.network.pdf') }}" class="btn-report btn-pdf">
                        <i class="fas fa-file-pdf mr-2"></i>PDF: Оборудование
                    </a>
                    <a href="{{ route('admin.reports.services.pdf') }}" class="btn-report btn-pdf">
                        <i class="fas fa-file-pdf mr-2"></i>PDF: Услуги
                    </a>
                </div>
            </div>
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <i class="fas fa-users mr-2 text-blue-500"></i>
                    Управление пользователями
                </h2>
                
                <div class="users-list-container">
                    <ul class="users-list">
                        @foreach($users as $user)
                            <li class="user-item group">
                                <a href="{{ route('admin.users.tariffs', $user->id_user) }}" class="user-link">
                                    <span class="user-name">{{ $user->fio }}</span>
                                    <span class="user-action">
                                        Просмотр услуг
                                        <i class="fas fa-external-link-alt ml-1 text-xs opacity-70"></i>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                @if($users->isEmpty())
                    <div class="empty-state bg-gray-50 rounded-lg p-4 text-center text-gray-500">
                        <i class="fas fa-user-slash text-2xl mb-2"></i>
                        <p>Нет пользователей для отображения</p>
                    </div>
                @endif
            </div>
                    @endif

        <h1 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Мои подключенные услуги</h1>

    @if($services->isEmpty())
        <div class="empty-state bg-white rounded-lg shadow p-8 text-center">
            <i class="fas fa-wifi-slash text-5xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-700 mb-2">У вас нет подключенных услуг</h3>
            <p class="text-gray-500 mb-6">Подключите услуги в нашем каталоге</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6">
            @foreach($services as $activation)
                <div class="service-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="service-card__header flex items-center p-6 
                        @if($activation->date_disconnection) bg-gray-500 @else bg-{{ $activation->service->type_services == 'Интернет' ? 'blue' : ($activation->service->type_services == 'ТВ' ? 'orange' : 'green') }}-500 @endif">
                        <div class="service-icon mr-4 text-white text-2xl">
                            @if($activation->service->type_services == 'Интернет')
                                <i class="fas fa-wifi"></i>
                            @elseif($activation->service->type_services == 'ТВ')
                                <i class="fas fa-tv"></i>
                            @else
                                <i class="fas fa-mobile-alt"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">{{ $activation->service->type_services }}</h3>
                            <p class="text-white opacity-90">{{ $activation->service->description_services }}</p>
                        </div>
                        <div class="ml-auto">
                            <span class="status-badge px-3 py-1 rounded-full text-xs font-medium 
                                @if($activation->date_disconnection) bg-gray-600 @else bg-white text-{{ $activation->service->type_services == 'Интернет' ? 'blue' : ($activation->service->type_services == 'ТВ' ? 'orange' : 'green') }}-600 @endif">
                                @if($activation->date_disconnection)
                                    Отключен
                                @else
                                    Активен
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="service-card__body p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Основная информация -->
                            <div class="info-group">
                                <h4 class="info-label">Тариф</h4>
                                <p class="info-value">{{ $activation->service->description_services }}</p>
                            </div>
                            
                            <div class="info-group">
                                <h4 class="info-label">Стоимость</h4>
                                <p class="info-value">{{ $activation->service->tariff_price }} ₽/мес</p>
                            </div>
                            
                            <div class="info-group">
                                <h4 class="info-label">Тип услуги</h4>
                                <p class="info-value">{{ $activation->service->type_services }}</p>
                            </div>
                            
                            <!-- Даты подключения/отключения -->
                            <div class="info-group">
                                <h4 class="info-label">Дата подключения</h4>
                                <p class="info-value">{{ $activation->date_connection ? $activation->date_connection->format('d.m.Y') : 'Не указана' }}</p>
                            </div>
                            
                            <div class="info-group">
                                <h4 class="info-label">Дата отключения</h4>
                                <p class="info-value">
                                    @if($activation->date_disconnection)
                                        {{ $activation->date_disconnection->format('d.m.Y') }}
                                    @else
                                        <span class="text-green-600">Активна</span>
                                    @endif
                                </p>
                            </div>
                            
                            <!-- Адрес и контактные данные -->
                            <div class="info-group">
                                <h4 class="info-label">Адрес подключения</h4>
                                <p class="info-value">{{ $activation->address_connection ?? 'Не указан' }}</p>
                            </div>
                            
                            @if($activation->name_guest)
                                <div class="info-group">
                                    <h4 class="info-label">Гостевое подключение</h4>
                                    <p class="info-value">{{ $activation->name_guest }} ({{ $activation->email_guest }})</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="service-card__footer bg-gray-50 px-6 py-4 border-t flex justify-between items-center">
                        <div class="actions">
                            @if(!$activation->date_disconnection)
                                <button class="btn-secondary mr-2" data-service-id="{{ $activation->id_connection }}">
                                    <i class="fas fa-cog mr-1"></i> Управление
                                </button>
                            @endif

                            {{-- Кнопка перехода к счёту, если он найден --}}
                            @php
                                $invoice = \App\Models\Invoice::where('id_user', $activation->id_user)
                                    ->where('id_services', $activation->id_services)
                                    ->where('id_connection', $activation->id_connection)
                                    ->first();
                            @endphp

                            @if($invoice)
                                <a href="{{ route('invoice.show', $invoice->id_invoice) }}" class="btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    <i class="fas fa-file-invoice-dollar mr-1"></i> Счёт
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection