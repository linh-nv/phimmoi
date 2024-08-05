import axiosInstance from "@/services/axiosInstance";

export const apiService = {
  async getAll(endpoint, page = 1) {
    try {
      const response = await axiosInstance.get(`${endpoint}?page=${page}`);
      return response.data;
    } catch (error) {
      handleError(error);
      throw error;
    }
  },

  async create(endpoint, data) {
    try {
      const response = await axiosInstance.post(endpoint, data, {
        headers: { "Content-Type": "multipart/form-data" },
      });
      return response.data;
    } catch (error) {
      handleError(error);
      throw error;
    }
  },

  async update(endpoint, id, data) {
    try {
      const response = await axiosInstance.put(`${endpoint}/${id}`, data);
      return response.data;
    } catch (error) {
      handleError(error);
      throw error;
    }
  },

  async find(endpoint, id) {
    try {
      const response = await axiosInstance.get(`${endpoint}/${id}`);
      return response.data;
    } catch (error) {
      handleError(error);
      throw error;
    }
  },

  async delete(endpoint, id) {
    try {
      const response = await axiosInstance.delete(`${endpoint}/${id}`);
      return response.data;
    } catch (error) {
      handleError(error);
      throw error;
    }
  },

  async search(endpoint, keyword) {
    try {
      const response = await axiosInstance.get(
        `${endpoint}?keyword=${keyword}`,
      );
      return response.data;
    } catch (error) {
      handleError(error);
      throw error;
    }
  },
};

function handleError(error) {
  if (error.response) {
    console.error(error.response.data.error || "Request failed.");
  } else {
    console.error("An unexpected error occurred.");
  }
}
