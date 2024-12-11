# Esempio di client per accedere a IUVOnline BPS

# Configurazione

## File OpenAPI

E' presente nella directory openAPI uno zip cifrato con le specifiche OpenAPI

## Installazione certificati

Decomprimere i certificati (POPSO_SVILUPPO) nella directory cert.

Il risultato sarà il seguente:

![certificati.png](img/certificati.png)

## Environment

Rinominare ed eventualmente modificare opportunamente il file .env.example in .env

### XML della chiamata

Create un file xml valido per la chiamata nella directory xml. Il file deve contenere l'XML generato secondo le specifiche inviate dalla Banca

### Composer

Eseguire `composer install` per installare le dipendenze

### Chiamata Effettiva

Ora è possibile eseguire il file chiamata.php dentro la directory src

```bash
php chiamata.php
```

# Chiamata via cUrl

È possibile verificare il funzionamento del servizio eseguendo una chiamata usando cUrl.

Si faccia riferimento a questo esempio:

```bash
curl --location '<url>' \
--key "./cert/POPSO_SVILUPPO/POPSO_SVILUPPO.pem" \
-E "./cert/POPSO_SVILUPPO/POPSO_SVILUPPO_CERT.pem" \
--cacert "./cert/PopsoRootCA01.pem" \
--header 'Content-Type:  application/json' \
--header 'X-Bps-Tt-IdOperazione-CodiceApplicazioneChiamante: COD_APPLICAZIONE' \
--header 'X-Bps-Tt-IdOperazione-CodiceOperazione:  codice_univoco' \
--header 'X-Bps-Tt-IdConversazione:  codice_univoco' \
--header 'X-Bps-Tc-CodiceApplicazione: COD_APPLICAZIONE' \
--header 'X-Bps-Tc-CodiceCanale:  ITN' \
--header 'X-Bps-Tc-CodiceIstituto:  05696' \
--data '{
  "IdTransazione": "codice_univoco",
  "CodiceServizio": "00001",
  "XmlMavOnline": "IMMETTERE QUI XML CODIFICATO IN BASE64"
}'
```

## Certificati CA produzione

I certificati **pubblici** della CA e Intermediate CA sono presenti nella directory public_CA

I certificati di autenticazione per la produzione vi verranno consegnati da personale della Banca.
