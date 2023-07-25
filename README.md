# qarawiyyin
La antigua biblioteca de Al-Qarawiyyin o Al-Karaouine (en árabe جامعة القرويين) en Fez es la más antigua de África. ... Al-Qarawiyyin incluye la universidad –la más antigua del mundo aunque reconocida como tal en 1947-, una mezquita y una serie de escuelas.

Arq. Soluciones: Arq. Malla

const express = require('express');
const CircuitBreaker = require('opossum');
const { Kafka } = require('kafkajs');

// Crea la instancia de express
const app = express();

// Configura Kafka
const kafka = new Kafka({
  clientId: 'mi-aplicacion',
  brokers: ['mi-broker.kafka.com:9092']
});

// Configura el productor de Kafka
const producer = kafka.producer();

// Función para hacer una llamada a un servicio externo
const externalServiceCall = () => {
  return new Promise((resolve, reject) => {
    // Lógica para llamar al servicio
    // Si todo va bien: resolve(data)
    // Si algo sale mal: reject(error)
  });
};

// Configura el circuit breaker
const options = {
  timeout: 3000, // Si nuestra llamada tarda más de 3 segundos, activa el circuit breaker
  errorThresholdPercentage: 50, // Si más del 50% de las solicitudes fallan, abre el circuito
  resetTimeout: 30000 // Después de 30 segundos intenta cerrar el circuito
};

const breaker = new CircuitBreaker(externalServiceCall, options);

// Maneja los eventos del circuit breaker
breaker.on('fallback', async (result) => {
  console.log('fallback', result);
  // Envía un mensaje a Kafka cuando el circuit breaker se activa
  await producer.send({
    topic: 'topic-de-errores',
    messages: [{ value: 'El circuit breaker se ha activado' }]
  });
});

// Define tu ruta
app.get('/ruta', async (req, res) => {
  try {
    const result = await breaker.fire();
    res.json(result);
  } catch (error) {
    res.status(503).send('El servicio no está disponible en este momento');
  }
});

// Inicia tu servidor
app.listen(3000, () => {
  console.log('El servidor está corriendo en el puerto 3000');
});


Deberás adaptarlo según tus necesidades. Por ejemplo, deberás reemplazar mi-broker.kafka.com:9092 por la dirección de tu broker de Kafka y mi-aplicacion por el nombre de tu aplicación.
