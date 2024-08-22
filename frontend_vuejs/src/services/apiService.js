import axiosInstance from "@/services/axiosInstance";

const handleApiCall = async (apiCall) => {
  try {
    const response = await apiCall();
    return response.data;
  } catch (error) {
    console.error(
      error.response?.data?.error || "An unexpected error occurred.",
    );
    throw error;
  }
};

export const apiService = {
  getAll: (endpoint, page = 1) =>
    handleApiCall(() => axiosInstance.get(`${endpoint}`, { params: { page } })),

  get: (endpoint) => handleApiCall(() => axiosInstance.get(`${endpoint}`)),

  create: (endpoint, data, headers = {}) =>
    handleApiCall(() =>
      axiosInstance.post(endpoint, data, {
        headers: { "Content-Type": "multipart/form-data", ...headers },
      }),
    ),

  update: (endpoint, slug, data, headers = {}) =>
    handleApiCall(() =>
      axiosInstance.put(`${endpoint}/${slug}`, data, { headers }),
    ),

  updateMovie: (endpoint, slug, data, headers = {}) =>
    handleApiCall(() =>
      axiosInstance.post(`${endpoint}/${slug}`, data, {
        headers: { "Content-Type": "multipart/form-data", ...headers },
      }),
    ),

  find: (endpoint, slug) =>
    handleApiCall(() => axiosInstance.get(`${endpoint}/${slug}`)),

  delete: (endpoint, slug) =>
    handleApiCall(() => axiosInstance.delete(`${endpoint}/${slug}`)),

  search: (endpoint, params = {}) =>
    handleApiCall(() => axiosInstance.get(endpoint, { params })),

  pluck: (endpoint) =>
    handleApiCall(() => axiosInstance.get("/pluck" + endpoint)),
};
