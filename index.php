<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" href="images/logo.png" type="image/png"/>
  <title>ScanHub - Social QR Generator</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1 {
      color: #333;
      margin-bottom: 20px;
      text-align: center;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
      gap: 15px;
      width: 100%;
      max-width: 1000px;
    }

    .card {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      font-size: 16px;
    }

    .card i {
      font-size: 24px;
      display: block;
      margin-bottom: 6px;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .active-input {
      margin-top: 30px;
      padding: 20px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 500px;
      text-align: center;
    }

    .input-wrapper {
      position: relative;
      margin-bottom: 15px;
      text-align: left;
    }

    .input-wrapper label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    .input-wrapper input[type="text"] {
      width: 100%;
      padding: 12px 16px;
      border-radius: 30px;
      border: 1px solid #ccc;
      font-size: 16px;
      outline: none;
      transition: border-color 0.3s ease;
    }

    .input-wrapper input[type="text"]:focus {
      border-color: #007bff;
    }

    button {
      padding: 10px 20px;
      border: none;
      background: #007bff;
      color: white;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #0056b3;
    }

    .qr-preview {
      margin-top: 20px;
    }

    img.qr-img {
      width: 200px;
      height: 200px;
      margin-top: 10px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 10px;
      background: white;
    }

    .loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid #007bff;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 20px auto;
    }

    .error-message {
      color: #d9534f;
      font-size: 14px;
      margin-top: 5px;
      display: none;
    }

    input.error {
      border-color: #d9534f;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @media (max-width: 600px) {
      .card {
        font-size: 14px;
        padding: 16px;
      }

      .card i {
        font-size: 20px;
      }
    }
  </style>
</head>
<body>

  <h1>ScanHub - Social QR Code Generator</h1>

  <div class="grid" id="card-grid">
    <div class="card" data-type="whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</div>
    <div class="card" data-type="instagram"><i class="fab fa-instagram"></i> Instagram</div>
    <div class="card" data-type="facebook"><i class="fab fa-facebook"></i> Facebook</div>
    <div class="card" data-type="twitter"><i class="fab fa-twitter"></i> Twitter</div>
    <div class="card" data-type="linkedin"><i class="fab fa-linkedin"></i> LinkedIn</div>
    <div class="card" data-type="youtube"><i class="fab fa-youtube"></i> YouTube</div>
    <div class="card" data-type="url"><i class="fas fa-globe"></i> Website</div>
    <div class="card" data-type="email"><i class="fas fa-envelope"></i> Email</div>
    <div class="card" data-type="text"><i class="fas fa-font"></i> Text</div>
    <div class="card" data-type="telegram"><i class="fab fa-telegram"></i> Telegram</div>
    <div class="card" data-type="snapchat"><i class="fab fa-snapchat"></i> Snapchat</div>
    <div class="card" data-type="pinterest"><i class="fab fa-pinterest"></i> Pinterest</div>
    <div class="card" data-type="tiktok"><i class="fab fa-tiktok"></i> TikTok</div>
    <div class="card" data-type="github"><i class="fab fa-github"></i> GitHub</div>
    <div class="card" data-type="reddit"><i class="fab fa-reddit"></i> Reddit</div>
    <div class="card" data-type="skype"><i class="fab fa-skype"></i> Skype</div>
    <div class="card" data-type="spotify"><i class="fab fa-spotify"></i> Spotify</div>
    <div class="card" data-type="paypal"><i class="fab fa-paypal"></i> PayPal</div>
  </div>

  <div class="active-input" id="input-area" style="display:none;">
    <form id="qrForm">
      <input type="hidden" name="qr_type" id="qr_type">
      <div class="input-wrapper">
        <label id="inputLabel">Enter value</label>
        <input type="text" name="input" id="input_field" required>
        <div class="error-message" id="error-message"></div>
      </div>
      <button type="submit">Generate QR</button>
    </form>
    <div class="loader" id="qrLoader" style="display:none;"></div>
    <div class="qr-preview" id="qrPreview" style="display:none;">
      <h3>Your QR Code</h3>
      <img id="qrImage" class="qr-img" src="" alt="QR Code">
      <br><br>
      <a id="downloadLink" download><button>Download</button></a>
    </div>
  </div>

  <script>
    const cards = document.querySelectorAll('.card');
    const inputArea = document.getElementById('input-area');
    const qrType = document.getElementById('qr_type');
    const inputField = document.getElementById('input_field');
    const inputLabel = document.getElementById('inputLabel');
    const qrPreview = document.getElementById('qrPreview');
    const qrImage = document.getElementById('qrImage');
    const qrLoader = document.getElementById('qrLoader');
    const downloadLink = document.getElementById('downloadLink');
    const errorMessage = document.getElementById('error-message');

    // Validation patterns
    const validationPatterns = {
      whatsapp: {
        pattern: /^(\+?\d{1,3}[- ]?)?\d{6,14}$/,
        message: 'Please enter a valid phone number (e.g. 923001234567 or +923001234567)'
      },
      email: {
        pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        message: 'Please enter a valid email address (e.g. example@email.com)'
      },
      url: {
        pattern: /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/,
        message: 'Please enter a valid URL (e.g. https://example.com)'
      },
      instagram: {
        pattern: /^[a-zA-Z0-9._]{1,30}$/,
        message: 'Instagram username can only contain letters, numbers, periods and underscores'
      },
      twitter: {
        pattern: /^[a-zA-Z0-9_]{1,15}$/,
        message: 'Twitter username can only contain letters, numbers and underscores (max 15 chars)'
      },
      facebook: {
        pattern: /^[a-zA-Z0-9.]{5,}$/,
        message: 'Facebook username can only contain letters, numbers and periods'
      },
      linkedin: {
        pattern: /^[a-zA-Z0-9-]{3,100}$/,
        message: 'LinkedIn username can only contain letters, numbers and hyphens'
      },
      telegram: {
        pattern: /^[a-zA-Z0-9_]{5,32}$/,
        message: 'Telegram username must be 5-32 characters (letters, numbers, underscores)'
      },
      snapchat: {
        pattern: /^[a-zA-Z][a-zA-Z0-9_]{2,15}$/,
        message: 'Snapchat username must start with a letter and be 3-15 characters long'
      },
      pinterest: {
        pattern: /^[a-zA-Z0-9_]{3,30}$/,
        message: 'Pinterest username must be 3-30 characters (letters, numbers, underscores)'
      },
      tiktok: {
        pattern: /^[a-zA-Z0-9._]{2,24}$/,
        message: 'TikTok username must be 2-24 characters (letters, numbers, periods, underscores)'
      },
      github: {
        pattern: /^[a-zA-Z0-9-]{1,39}$/,
        message: 'GitHub username can only contain letters, numbers and hyphens (max 39 chars)'
      },
      reddit: {
        pattern: /^[a-zA-Z0-9_-]{3,20}$/,
        message: 'Reddit username must be 3-20 characters (letters, numbers, underscores, hyphens)'
      },
      skype: {
        pattern: /^[a-zA-Z][a-zA-Z0-9_.,-]{5,31}$/,
        message: 'Skype username must start with a letter and be 6-32 characters long'
      },
      spotify: {
        pattern: /^[a-zA-Z0-9]{5,}$/,
        message: 'Spotify username must be at least 5 characters (letters and numbers)'
      },
      paypal: {
        pattern: /^[a-zA-Z0-9._-]{3,}$/,
        message: 'PayPal username must be at least 3 characters (letters, numbers, periods, underscores, hyphens)'
      },
      youtube: {
        pattern: /^[a-zA-Z0-9_-]{3,}$/,
        message: 'YouTube username must be at least 3 characters (letters, numbers, underscores, hyphens)'
      },
      text: {
        pattern: /^.{1,500}$/,
        message: 'Text must be between 1 and 500 characters'
      }
    };

    cards.forEach(card => {
      card.addEventListener('click', () => {
        const type = card.getAttribute('data-type');
        qrType.value = type;
        inputField.value = '';
        qrPreview.style.display = 'none';
        inputArea.style.display = 'block';
        errorMessage.style.display = 'none';
        inputField.classList.remove('error');

        let placeholder = 'Enter value';
        switch (type) {
          case 'whatsapp': placeholder = 'e.g. 923001234567 or +923001234567'; break;
          case 'email': placeholder = 'e.g. example@email.com'; break;
          case 'text': placeholder = 'e.g. Hello world (max 500 chars)'; break;
          case 'url': placeholder = 'e.g. https://example.com'; break;
          case 'instagram': placeholder = 'e.g. username (no @)'; break;
          case 'twitter': placeholder = 'e.g. username (no @)'; break;
          case 'facebook': placeholder = 'e.g. username or profile ID'; break;
          case 'linkedin': placeholder = 'e.g. username or profile ID'; break;
          case 'telegram': placeholder = 'e.g. username (no @)'; break;
          case 'snapchat': placeholder = 'e.g. username (no @)'; break;
          case 'pinterest': placeholder = 'e.g. username'; break;
          case 'tiktok': placeholder = 'e.g. username (no @)'; break;
          case 'github': placeholder = 'e.g. username'; break;
          case 'reddit': placeholder = 'e.g. username (no u/)'; break;
          case 'skype': placeholder = 'e.g. username or live:user'; break;
          case 'spotify': placeholder = 'e.g. username'; break;
          case 'paypal': placeholder = 'e.g. username'; break;
          case 'youtube': placeholder = 'e.g. username or channel ID'; break;
          default: placeholder = 'e.g. username';
        }
        inputLabel.textContent = 'Enter ' + type.charAt(0).toUpperCase() + type.slice(1);
        inputField.placeholder = placeholder;
      });
    });

    function validateInput(type, value) {
      if (!validationPatterns[type]) return true; // No validation for this type
      
      const pattern = validationPatterns[type].pattern;
      return pattern.test(value);
    }

    function showError(message) {
      errorMessage.textContent = message;
      errorMessage.style.display = 'block';
      inputField.classList.add('error');
      return false;
    }

    function hideError() {
      errorMessage.style.display = 'none';
      inputField.classList.remove('error');
      return true;
    }

    inputField.addEventListener('input', function() {
      const type = qrType.value;
      const value = inputField.value.trim();
      
      if (value === '') {
        hideError();
        return;
      }
      
      if (validateInput(type, value)) {
        hideError();
      } else {
        showError(validationPatterns[type].message);
      }
    });

    document.getElementById('qrForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const type = qrType.value;
      const input = inputField.value.trim();
      
      if (!input) {
        return showError('This field is required');
      }
      
      if (!validateInput(type, input)) {
        return showError(validationPatterns[type].message);
      }

      let data = '';
      switch (type) {
        case 'whatsapp': 
          data = `https://wa.me/${input.replace(/[^0-9+]/g, '')}`; 
          break;
        case 'email': 
          data = `mailto:${input}`; 
          break;
        case 'facebook': 
          data = `https://facebook.com/${input}`; 
          break;
        case 'twitter': 
          data = `https://twitter.com/${input}`; 
          break;
        case 'instagram': 
          data = `https://instagram.com/${input}`; 
          break;
        case 'youtube': 
          data = `https://youtube.com/${input}`; 
          break;
        case 'linkedin': 
          data = `https://linkedin.com/in/${input}`; 
          break;
        case 'telegram': 
          data = `https://t.me/${input}`; 
          break;
        case 'snapchat': 
          data = `https://www.snapchat.com/add/${input}`; 
          break;
        case 'pinterest': 
          data = `https://pinterest.com/${input}`; 
          break;
        case 'tiktok': 
          data = `https://tiktok.com/@${input}`; 
          break;
        case 'github': 
          data = `https://github.com/${input}`; 
          break;
        case 'reddit': 
          data = `https://reddit.com/user/${input}`; 
          break;
        case 'skype': 
          data = `skype:${input}?chat`; 
          break;
        case 'spotify': 
          data = `https://open.spotify.com/user/${input}`; 
          break;
        case 'paypal': 
          data = `https://paypal.me/${input}`; 
          break;
        case 'url': 
          data = input.startsWith('http') ? input : `https://${input}`;
          break;
        case 'text': 
          data = input; 
          break;
      }

      const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(data)}&size=200x200`;

      qrPreview.style.display = 'none';
      qrLoader.style.display = 'block';

      // simulate loading
      setTimeout(() => {
        qrImage.src = qrUrl;
        downloadLink.href = qrUrl;
        downloadLink.download = `ScanHub-${type}.png`;
        qrLoader.style.display = 'none';
        qrPreview.style.display = 'block';
      }, 1000);
    });
  </script>
</body>
</html>