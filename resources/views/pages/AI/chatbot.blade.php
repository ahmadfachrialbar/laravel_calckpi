@extends('layouts.app')

@section('content')
<h4 class="h3 mb-2 text-gray-700 font-weight-bold">🤖 Chatbot Panduan KPI</h4>
<hr class="divider">

<div class="row">
    <!-- Kolom Chatbot -->
    <div class="col-md-7">
        <div class="card shadow p-3">
            <div id="chat-box" class="border rounded p-3 mb-2"
                style="height:350px; overflow-y:auto; background:#f0f0f0; font-size:14px;">
                <div class="text-muted text-center"><em>🤖 Bot siap membantu Anda...</em></div>
            </div>
            <div class="input-group">
                <input type="text" id="user-input" class="form-control" placeholder="Ketik pertanyaan...">
                <button class="btn btn-dark ml-2" id="send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
                <button class="btn btn-danger ml-2 d-none" id="stop-btn">
                    <i class="fas fa-stop"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Kolom Penjelasan AI -->
    <div class="col-md-5">
        <div class="card shadow p-3">
            <h5 class="text-gray-700 font-weight-bold">ℹ️ Tentang Chatbot</h5>
            <p class="text-muted" style="font-size:14px;">
                Chatbot ini menggunakan teknologi <strong>Gemini AI</strong> untuk membantu Anda memahami
                penggunaan website <strong>Calculating KPI PT Anugrah Beton Nusantara</strong>.
            </p>
            <p class="text-muted"><em>
                Chatbot akan menjelaskan fitur sesuai peran (Karyawan, Admin, Direksi). Anda juga bisa bertanya hal umum ringan.
            </em></p>
        </div>
    </div>
</div>
<a href="{{ route('dashboard') }}" class="mt-3 btn btn-secondary">Kembali</a>

<style>
    /* Styling chat bubble ala WhatsApp */
    .chat-bubble {
        max-width: 75%;
        padding: 8px 12px;
        border-radius: 15px;
        margin-bottom: 8px;
        display: inline-block;
        word-wrap: break-word;
    }
    .user-bubble {
        background: #dcf8c6;
        color: #333;
        float: right;
        clear: both;
    }
    .bot-bubble {
        background: #ffffff;
        color: #333;
        float: left;
        clear: both;
    }
    .bot-bubble strong {
        font-weight: bold;
    }
    .bot-bubble ul {
        padding-left: 20px;
        margin-bottom: 0;
    }
</style>

<script>
    let typingInterval; // Untuk stop typing
    let isTyping = false;

    document.getElementById('send-btn').addEventListener('click', sendMessage);
    document.getElementById('stop-btn').addEventListener('click', stopTyping);
    document.getElementById('user-input').addEventListener('keypress', e => {
        if (e.key === 'Enter') sendMessage();
    });

    function sendMessage() {
        let input = document.getElementById('user-input');
        let message = input.value.trim();
        if (!message || isTyping) return;

        let chatBox = document.getElementById('chat-box');
        chatBox.innerHTML += `<div class="chat-bubble user-bubble"><b>Anda:</b> ${message}</div>`;
        input.value = '';
        chatBox.scrollTop = chatBox.scrollHeight;

        let typingDiv = document.createElement("div");
        typingDiv.classList.add("text-muted", "bot-bubble");
        typingDiv.innerHTML = "<em>🤖 Bot sedang mengetik...</em>";
        chatBox.appendChild(typingDiv);
        chatBox.scrollTop = chatBox.scrollHeight;

        fetch("{{ route('chatbot.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => res.json())
        .then(data => {
            typingDiv.remove();
            typeEffect(`🤖 ${data.answer}`, chatBox);
        })
        .catch(() => {
            typingDiv.remove();
            chatBox.innerHTML += `<div class="text-danger bot-bubble"><em>⚠️ Gagal terhubung ke server.</em></div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }

    function typeEffect(text, chatBox) {
        let i = 0;
        isTyping = true;
        document.getElementById('stop-btn').classList.remove('d-none');

        let div = document.createElement("div");
        div.classList.add("chat-bubble", "bot-bubble");
        chatBox.appendChild(div);

        let formattedText = text
            .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>") // Bold (**text**)
            .replace(/\n/g, "<br>")                           // Line breaks
            .replace(/- (.*?)(?=<|$)/g, "<li>$1</li>");       // Bullet list

        // Tambahkan <ul> untuk list jika ada <li>
        if (formattedText.includes("<li>")) {
            formattedText = "<ul>" + formattedText + "</ul>";
        }

        function typing() {
            if (i < formattedText.length && isTyping) {
                div.innerHTML = formattedText.slice(0, i);
                i++;
                chatBox.scrollTop = chatBox.scrollHeight;
                typingInterval = setTimeout(typing, 15);
            } else {
                isTyping = false;
                document.getElementById('stop-btn').classList.add('d-none');
            }
        }
        typing();
    }

    function stopTyping() {
        clearTimeout(typingInterval);
        isTyping = false;
        document.getElementById('stop-btn').classList.add('d-none');
    }
</script>
@endsection
