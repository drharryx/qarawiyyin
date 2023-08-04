# qarawiyyin
La antigua biblioteca de Al-Qarawiyyin o Al-Karaouine (en árabe جامعة القرويين) en Fez es la más antigua de África. ... Al-Qarawiyyin incluye la universidad –la más antigua del mundo aunque reconocida como tal en 1947-, una mezquita y una serie de escuelas.


const axios = require('axios');

const getItem = async () => {
    const url = 'https://dynamodb.us-west-2.amazonaws.com'; // Camba esto a tu endpoint de DynamoDB
    const headers = {
        'Content-Type': 'application/x-amz-json-1.0',
        'X-Amz-Target': 'DynamoDB_20120810.GetItem',
        'Authorization': 'tu-token-de-autorizacion', // proporcionar un token de autorización válido
    };
    const data = {
        "TableName": "nombre-de-tu-tabla",
        "Key": {
            "tu-llave-primaria": {
                "S": "valor-de-tu-llave"
            }
        }
    };
    
    try {
        const response = await axios.post(url, data, { headers });
        console.log(response.data);
    } catch (error) {
        console.error(error);
    }
};

getItem();
