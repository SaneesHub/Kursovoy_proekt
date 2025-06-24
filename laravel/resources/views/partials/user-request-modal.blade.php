<style>
    #support-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 350px;
        max-height: 80vh;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        font-family: Arial, sans-serif;
    }

    #support-header {
        background-color: #007bff;
        color: white;
        padding: 10px;
        cursor: pointer;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    #support-body {
        background: #fff;
        display: none;
        padding: 10px;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 10px 10px;
        overflow-y: auto;
        max-height: 60vh;
    }

    #chat-box {
        max-height: 200px;
        overflow-y: auto;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        padding: 5px;
    }

    .chat-message {
        margin-bottom: 5px;
    }

    .chat-message.user {
        text-align: right;
        color: blue;
    }

    .chat-message.operator {
        text-align: left;
        color: green;
    }

    textarea {
        resize: none;
    }
</style>

<div id="support-widget">
    <div id="support-header">Поддержка</div>
    <div id="support-body">
        <div id="request-form">
            <form id="user-request-form">
                @csrf
                <div class="mb-2">
                    <label for="type_request">Тип запроса:</label>
                    <select name="type_request" class="form-control" required>
                        <option value="Ошибка">Ошибка</option>
                        <option value="Подключение услуги">Подключение услуги</option>
                        <option value="Вопрос">Вопрос</option>
                        <option value="Другое">Другое</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="message">Сообщение:</label>
                    <textarea name="message" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-primary w-100">Отправить</button>
            </form>
        </div>

        <div id="chat-box" style="display: none;"></div>

        <form id="chat-form" style="display: none;">
            @csrf
            <input type="hidden" name="id_request" id="chat-request-id">
            <div class="mb-2">
                <textarea name="message" class="form-control" placeholder="Введите сообщение..." required></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-success w-100">Отправить сообщение</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('support-header').addEventListener('click', function () {
        let body = document.getElementById('support-body');
        body.style.display = (body.style.display === 'block') ? 'none' : 'block';
    });

    document.getElementById('user-request-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route('user-request.send') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': formData.get('_token') },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('request-form').style.display = 'none';
                document.getElementById('chat-form').style.display = 'block';
                document.getElementById('chat-box').style.display = 'block';
                document.getElementById('chat-request-id').value = data.request_id;
                loadMessages(data.request_id);
            }
        });
    });

    document.getElementById('chat-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route('user-request.message') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': formData.get('_token') },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadMessages(formData.get('id_request'));
                this.reset();
            }
        });
    });

    function loadMessages(requestId) {
        fetch(`/user-request/${requestId}/messages`)
            .then(res => res.json())
            .then(messages => {
                const box = document.getElementById('chat-box');
                box.innerHTML = '';
                messages.forEach(msg => {
                    let div = document.createElement('div');
                    div.className = 'chat-message ' + (msg.from_user ? 'user' : 'operator');
                    div.textContent = msg.content;
                    box.appendChild(div);
                });
                box.scrollTop = box.scrollHeight;
            });
    }
</script>
@include('partials.user-request-modal')
