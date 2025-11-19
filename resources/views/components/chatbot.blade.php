<style>
    /* BURBUJA */
    .chatbot-button {
        position: fixed;
        bottom: 25px;
        right: 25px;
        width: 65px;
        height: 65px;
        background: #4f46e5;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 32px;
        cursor: pointer;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        transition: 0.3s;
    }

    .chatbot-button:hover {
        transform: scale(1.08);
    }

    /* VENTANA DE CHAT */
    .chatbot-window {
        position: fixed;
        bottom: 100px;
        right: 25px;
        width: 350px;
        max-height: 450px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        display: none;
        flex-direction: column;
        z-index: 9999;
    }

    .chatbot-header {
        background: #4f46e5;
        color: white;
        padding: 12px;
        font-weight: bold;
        border-radius: 12px 12px 0 0;
        text-align: center;
    }

    .chatbot-messages {
        padding: 12px;
        height: 300px;
        overflow-y: auto;
        font-size: 14px;
    }

    .chatbot-input-area {
        display: flex;
        border-top: 1px solid #ddd;
    }

    .chatbot-input-area input {
        flex: 1;
        padding: 10px;
        border: none;
        outline: none;
    }

    .chatbot-input-area button {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 10px 16px;
        cursor: pointer;
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
        const windowBox = document.getElementById("chatbotWindow");
        windowBox.style.display = windowBox.style.display === "flex" ? "none" : "flex";
    }

    function addMessage(content, sender) {
        const messages = document.getElementById("chatMessages");
        const bubble = document.createElement("div");

        bubble.style.padding = "8px";
        bubble.style.margin = "6px 0";
        bubble.style.borderRadius = "8px";

        if (sender === "user") {
            bubble.style.background = "#e0e7ff";
            bubble.style.textAlign = "right";
        } else {
            bubble.style.background = "#f3f4f6";
            bubble.style.textAlign = "left";
        }

        bubble.innerText = content;
        messages.appendChild(bubble);
        messages.scrollTop = messages.scrollHeight;
    }

    function sendChatMessage() {
        const input = document.getElementById("chatInput");
        const question = input.value.trim();

        if (!question) return;

        addMessage(question, "user");
        input.value = "";

        // Enviar a Laravel
        fetch("{{ route('chatbot.ask') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ question })
        })
            .then(r => r.json())
            .then(data => {
                addMessage(data.answer, "bot");
            });
    }
</script>