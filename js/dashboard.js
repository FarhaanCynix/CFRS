// Define a function to fetch reservation statuses
function fetchReservationStatuses() {
    fetch('get_reservation_statuses.php')
      .then(response => response.json())
      .then(data => {
        // Update the user dashboard with the latest reservation statuses
        // You'll need to write code to update the HTML based on the response data
        // For example, loop through facilities and update their status
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  }
  
  // Fetch reservation statuses initially when the page loads
  fetchReservationStatuses();
  
  // Set up an interval to fetch updates every 30 seconds (30000 milliseconds)
  setInterval(fetchReservationStatuses, 30000);
  