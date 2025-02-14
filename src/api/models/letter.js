import mongoose from 'mongoose';

const letterSchema = new mongoose.Schema({
  name: {
    type: String,
    required: true
  },
  message: {
    type: String,
    required: true
  },
  avatar: {
    type: String,
    default: '/assets/images/defaultavatar.jpeg'
  },
  timestamp: {
    type: Date,
    default: Date.now
  }
});

export default mongoose.model('Letter', letterSchema);