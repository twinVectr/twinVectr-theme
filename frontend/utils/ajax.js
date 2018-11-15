const axios = require('axios');

async function get(queryParams= {}) {
    try {
      const response = await axios({
        method:'get',
        ...queryParams,
      });
      return response;
    } catch (error) {
      console.error(error);
    }
  }


  module.exports = {
    get,
  }