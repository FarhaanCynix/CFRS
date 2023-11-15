  // Function to show the popup
  function showPopup() {
    document.getElementById('popup').style.display = 'block';
  }

  // Function to hide the popup
  function hidePopup() {
    document.getElementById('popup').style.display = 'none';
  }

  // Check if an error message is present in the URL and display the popup if needed
  const urlParams = new URLSearchParams(window.location.search);
  const error = urlParams.get('error');
  if (error) {
    document.getElementById('error-message').textContent = error;
    showPopup();
  }