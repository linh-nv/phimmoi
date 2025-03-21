import axiosInstance from "@/services/axiosInstance";
import axios from "axios";

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

  get: (endpoint, params = "") =>
    handleApiCall(() => axiosInstance.get(`${endpoint}`, { params })),

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

  search: (endpoint, keyword = "") =>
    handleApiCall(() => axiosInstance.get(endpoint, { params: { keyword } })),

  pluck: (endpoint) =>
    handleApiCall(() => axiosInstance.get("/pluck" + endpoint)),
  getByUrl(url) {
    return handleApiCall(() => axios.get(url));
  },
  redirect() {
    return handleApiCall(() => axiosInstance.get("/redirect"));
  },
};
