import axiosInstance from "@/services/axiosInstance";

const handleApiCall = async (apiCall) => {
  try {
    const response = await apiCall();
    return response.data;
  } catch (error) {
    console.error(error.response?.data?.error || "An unexpected error occurred.");
    throw error;
  }
};

export const apiService = {
  getAll: (endpoint, page = 1) => 
    handleApiCall(() => axiosInstance.get(`${endpoint}`, { params: { page } })),

  create: (endpoint, data, headers = {}) => 
    handleApiCall(() => axiosInstance.post(endpoint, data, { headers: { "Content-Type": "multipart/form-data", ...headers } })),

  update: (endpoint, id, data, headers = {}) => 
    handleApiCall(() => axiosInstance.put(`${endpoint}/${id}`, data, { headers })),

  find: (endpoint, id) => 
    handleApiCall(() => axiosInstance.get(`${endpoint}/${id}`)),

  delete: (endpoint, id) => 
    handleApiCall(() => axiosInstance.delete(`${endpoint}/${id}`)),

  search: (endpoint, params = {}) => 
    handleApiCall(() => axiosInstance.get(endpoint, { params })),
};
