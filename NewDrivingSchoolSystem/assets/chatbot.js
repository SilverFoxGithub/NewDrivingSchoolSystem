document.addEventListener("DOMContentLoaded", function () {
    const chatInput = document.getElementById("chat-input");
    const sendButton = document.getElementById("send-button");
    const chatMessages = document.getElementById("chat-messages");

    sendButton.addEventListener("click", function () {
        handleUserInput();
    });

    chatInput.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            handleUserInput();
        }
    });

    function handleUserInput() {
        const userMessage = chatInput.value.trim();
        if (userMessage === "") return;

        addMessage("user", userMessage);

        fetchAIResponse(userMessage);
        chatInput.value = "";
    }

    function fetchAIResponse(userMessage) {
        fetch("api/gemini_chatbot.php", { // Relative path to PHP backend
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ message: userMessage })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log response data for debugging
            if (data && data.response) {
                addMessage("ai", data.response);
            } else {
                addMessage("ai", "Sorry, I couldn't get a response.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            addMessage("ai", "Sorry, something went wrong.");
        });
    }

    function addMessage(sender, text) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message", sender);
        messageDiv.textContent = text;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
