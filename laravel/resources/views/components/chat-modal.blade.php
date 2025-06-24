<div id="chatModal" class="fixed bottom-4 right-4 z-50 w-80 bg-white border border-gray-300 shadow-lg rounded-lg hidden">
    <div class="bg-blue-600 text-white px-4 py-2 rounded-t-lg flex justify-between items-center">
        <span class="font-semibold">Чат с поддержкой</span>
        <button onclick="toggleChat()" class="text-white">&times;</button>
    </div>

    <div id="chatMessages" class="p-3 h-64 overflow-y-auto">
        <!-- Сообщения будут здесь -->
    </div>

    <form id="chatForm" class="p-2 flex gap-2">
        <input type="text" id="chatInput" placeholder="Введите сообщение..." 
               class="flex-1 border px-2 py-1 rounded" required>
        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">
            Отправить
        </button>
    </form>
</div>

<script>
// Состояние чата
const chatState = {
    requestId: null,
    isSending: false,
    retryCount: 0
};

// Инициализация
document.addEventListener('DOMContentLoaded', () => {
    console.log("[Чат] Инициализация");
    
    const chatForm = document.getElementById('chatForm');
    if (!chatForm) {
        console.error("[Чат] Форма не найдена");
        return;
    }

    chatForm.addEventListener('submit', handleSubmit);
});

// Обработка отправки
// Получаем CSRF-токен
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

// Модифицированный обработчик отправки
async function handleSubmit(e) {
    e.preventDefault();
    
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (!message || chatState.isSending) return;
    
    chatState.isSending = true;
    console.log("[Чат] Начало отправки:", message);

    const csrfToken = getCsrfToken();
    if (!csrfToken) {
        console.error("[Чат] CSRF-токен не найден!");
        alert("Ошибка безопасности. Перезагрузите страницу.");
        return;
    }

    try {
        // ... остальной код без изменений ...
        const response = await fetch('/chat/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Используем полученный токен
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message })
        });
        // ... 
    } catch (error) {
        console.error("[Чат] Ошибка:", error.message);
        alert(`Ошибка: ${error.message}`);
    } finally {
        chatState.isSending = false;
    }
}
// Добавление сообщения в интерфейс
async function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (!message) return;

    try {
        // 1. Создаем запрос или получаем существующий
        const response = await fetch('/chat/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message })
        });

        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.error || 'Ошибка сервера');
        }

        // 2. Добавляем сообщение в интерфейс
        addMessageToChat({
            content: message,
            id_user: {{ auth()->id() }},
            date_sending: new Date().toISOString()
        }, true);
        
        input.value = '';
        
    } catch (error) {
        console.error('Ошибка:', error);
        alert('Ошибка отправки: ' + error.message);
    }
}
</script>