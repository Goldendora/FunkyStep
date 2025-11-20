<style>
    /* === Chatbot Funkystep === */

    .chatbot-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 70px;
        height: 70px;
        background: var(--primary);
        color: var(--light);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 32px;
        cursor: pointer;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.5);
        z-index: 9999;
        transition: 0.3s ease;
        border: 3px solid var(--secondary);
    }

    .chatbot-button:hover {
        transform: scale(1.12);
        background: var(--secondary);
        border-color: var(--primary);
    }

    /* Ventana */
    .chatbot-window {
        position: fixed;
        bottom: 110px;
        right: 30px;
        width: 360px;
        max-height: 500px;
        background: rgba(20, 20, 20, 0.92);
        border-radius: 14px;
        border: 2px solid var(--secondary);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.7);
        display: none;
        flex-direction: column;
        backdrop-filter: blur(5px);
        z-index: 9999;
        overflow: hidden;
    }

    /* Header */
    .chatbot-header {
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        color: white;
        padding: 14px;
        font-weight: 800;
        text-align: center;
        letter-spacing: 1px;
        font-size: 1.1rem;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    /* Mensajes */
    .chatbot-messages {
        padding: 12px;
        height: 330px;
        overflow-y: auto;
        font-size: 14px;
        color: #fff;
    }

    /* Estilo burbujas */
    .chat-msg {
        padding: 10px 14px;
        max-width: 80%;
        margin-bottom: 10px;
        border-radius: 10px;
        line-height: 1.5;
        font-size: 0.93rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.35);
        animation: fadeIn 0.25s ease-out;
    }

    .chat-user {
        background: var(--secondary);
        margin-left: auto;
        text-align: right;
        color: white;
    }

    .chat-bot {
        background: #2b2b2b;
        border-left: 3px solid var(--primary);
        text-align: left;
        color: #eee;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(4px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Input */
    .chatbot-input-area {
        display: flex;
        border-top: 1px solid #333;
        background: rgba(0, 0, 0, 0.4);
    }

    .chatbot-input-area input {
        flex: 1;
        padding: 12px;
        background: rgba(255, 255, 255, 0.05);
        border: none;
        color: white;
        outline: none;
        font-size: 0.95rem;
    }

    .chatbot-input-area button {
        background: var(--secondary);
        border: none;
        padding: 12px 18px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .chatbot-input-area button:hover {
        background: var(--primary);
    }

    /* Scrollbar Funkystep */
    .chatbot-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chatbot-messages::-webkit-scrollbar-thumb {
        background: var(--secondary);
        border-radius: 4px;
    }
</style>


<!-- BURBUJA -->
<div class="chatbot-button" onclick="toggleChatbot()">💬</div>

<!-- VENTANA DEL CHAT -->
<div class="chatbot-window" id="chatbotWindow">
    <div class="chatbot-header">Asistente Funkystep</div>

    <div class="chatbot-messages" id="chatMessages"></div>

    <div class="chatbot-input-area">
        <input type="text" id="chatInput" placeholder="Escribe tu mensaje...">
        <button onclick="sendChatMessage()">Enviar</button>
    </div>
</div>

<script>
    function toggleChatbot() {
        const box = document.getElementById("chatbotWindow");
        box.style.display = box.style.display === "flex" ? "none" : "flex";
    }

    function addMessage(content, sender) {
        const container = document.getElementById("chatMessages");
        const bubble = document.createElement("div");

        bubble.classList.add("chat-msg");
        bubble.classList.add(sender === "user" ? "chat-user" : "chat-bot");

        bubble.innerText = content;
        container.appendChild(bubble);
        container.scrollTop = container.scrollHeight;
    }

    function sendChatMessage() {
        const input = document.getElementById("chatInput");
        const question = input.value.trim();
        if (!question) return;

        addMessage(question, "user");
        input.value = "";

        fetch("{{ route('chatbot.ask') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ question })
        })
            .then(res => res.json())
            .then(data => {
                addMessage(data.answer, "bot");
            })
            .catch(() => {
                addMessage("⚠ Hubo un error al conectar con el asistente.", "bot");
            });
    }
</script>