// filepath: flarum-ext-chatbot/js/forum/index.js
import app from 'flarum/forum/app';

app.initializers.add('AI Support', () => {
    console.log('Chatbot AI extension loaded!');

    // Tambahkan tombol atau widget untuk chatbot
    const chatbotButton = document.createElement('button');
    chatbotButton.innerText = 'Chat with AI';
    chatbotButton.style.position = 'fixed';
    chatbotButton.style.bottom = '20px';
    chatbotButton.style.right = '20px';
    chatbotButton.style.padding = '10px 20px';
    chatbotButton.style.backgroundColor = '#4caf50';
    chatbotButton.style.color = '#fff';
    chatbotButton.style.border = 'none';
    chatbotButton.style.borderRadius = '5px';
    chatbotButton.style.cursor = 'pointer';

    chatbotButton.onclick = () => {
        const userMessage = prompt('Ask the AI:');
        if (userMessage) {
            fetch(app.forum.attribute('apiUrl') + '/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: userMessage })
            })
                .then(response => response.json())
                .then(data => alert('AI Reply: ' + data.reply))
                .catch(error => console.error('Error:', error));
        }
    };

    document.body.appendChild(chatbotButton);
});