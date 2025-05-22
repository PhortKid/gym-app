<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>QR Code Scanner with POST</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    #reader-wrapper {
      width: 95%;
      max-width: 500px;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    #reader {
      width: 100%;
    }

    @media(min-width: 768px) {
      #reader-wrapper {
        width: 60%;
      }
    }

    @media(min-width: 1200px) {
      #reader-wrapper {
        width: 40%;
      }
    }
  </style>
</head>
<body>

  <h2 style="text-align:center;">Amazing Fitness Gym</h2>
  <div id="reader-wrapper">
    <div id="reader"></div>
  </div>
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  async function onScanSuccess(decodedText, decodedResult) {
    // Stop scanning
    html5QrcodeScanner.clear();

    try {
      const response = await fetch(`/api/scan/${decodedText}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          time_in: new Date().toISOString()
        }),
      });

      const result = await response.json();

      if (result.status === 'success') {
        // Display user info in table using SweetAlert
        Swal.fire({
          title: 'Attendance Recorded',
          html: `
            <table style="width:100%; text-align:left; font-size:14px;">
              <tr><th>Full Name:</th><td>${result.user.full_name}</td></tr>
              <tr><th>Gender:</th><td>${result.user.gender}</td></tr>
              <tr><th>Phone:</th><td>${result.user.phone_number}</td></tr>
              <tr><th>Email:</th><td>${result.user.email}</td></tr>
              <tr><th>Nationality:</th><td>${result.user.nationality}</td></tr>
              <tr><th>Address:</th><td>${result.user.address}</td></tr>
              <tr><th>Start Date:</th><td>${result.user.start_date}</td></tr>
              <tr><th>Expiry Date:</th><td>${result.user.expiry_date}</td></tr>
            </table>
          `,
          icon: 'success',
          confirmButtonText: 'OK'
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: result.message || 'Something went wrong!',
        });
      }

    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Fetch Error',
        text: error.message
      });
    }
  }

  const html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 }
  );

  html5QrcodeScanner.render(onScanSuccess);
</script>

{{--
<script>
  async function onScanSuccess(decodedText, decodedResult) {
    // Stop scanning
    html5QrcodeScanner.clear();

    try {
      const response = await fetch(`/api/scan/${decodedText}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          time_in: new Date().toISOString()
        }),
      });

      const result = await response.json();
      if (result.status === 'success') {
  // Display user info in table using SweetAlert
  Swal.fire({
    title: 'Attendance Recorded',
    html: `
      <table style="width:100%; text-align:left; font-size:14px;">
        <tr><th>Full Name:</th><td>${result.user.full_name}</td></tr>
        <tr><th>Gender:</th><td>${result.user.gender}</td></tr>
        <tr><th>Phone:</th><td>${result.user.phone_number}</td></tr>
        <tr><th>Email:</th><td>${result.user.email}</td></tr>
        <tr><th>Nationality:</th><td>${result.user.nationality}</td></tr>
        <tr><th>Address:</th><td>${result.user.address}</td></tr>
        <tr><th>Start Date:</th><td>${result.user.start_date}</td></tr>
        <tr><th>Expiry Date:</th><td>${result.user.expiry_date}</td></tr>
      </table>
    `,
    icon: 'success',
    confirmButtonText: 'OK'
  }).then(() => {
          location.reload(); // refresh the page after user clicks OK
        });
}
/*
      if (result.status === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'User attendance recorded successfully!',
          confirmButtonText: 'OK'
        }).then(() => {
          location.reload(); // refresh the page after user clicks OK
        });
        */
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: result.message || 'Something went wrong!',
        });
      }

    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Fetch Error',
        text: error.message
      });
    }
  }
/*
  const html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 }
  );
*/ 
const html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", { fps: 10, qrbox: 250 }
    );

    
  html5QrcodeScanner.render(onScanSuccess);
</script>
--}}
  

</body>
</html>
