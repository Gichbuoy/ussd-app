const express = require('express');
const bodyParser = require('body-parser');

const app = express();
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));

// In-memory storage for votes and users
// In a production environment, use a database instead
const votes = { option1: 0, option2: 0 };
const votedUsers = new Set();

app.post('/ussd', (req, res) => {
  const { sessionId, serviceCode, phoneNumber, text } = req.body;

  let response = '';

  if (text === '') {
    // This is the first request
    response = `CON Welcome to the Voting System
    1. Vote for Option 1
    2. Vote for Option 2
    3. View Results`;
  } else if (text === '1' || text === '2') {
    if (votedUsers.has(phoneNumber)) {
      // User has already voted
      response = `END You have already voted. You can't vote again.`;
    } else {
      // Record the vote
      const option = text === '1' ? 'option1' : 'option2';
      votes[option]++;
      votedUsers.add(phoneNumber);
      response = `END Thank you for voting for Option ${text}!`;
    }
  } else if (text === '3') {
    // View results
    response = `END Current Voting Results:
    Option 1: ${votes.option1} votes
    Option 2: ${votes.option2} votes`;
  } else {
    // Invalid input
    response = `END Invalid input. Please try again.`;
  }

  // Send the response back to the API
  res.set('Content-Type', 'text/plain');
  res.send(response);
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});