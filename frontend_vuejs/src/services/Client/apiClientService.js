import clientAxiosInstance from "./clientAxiosInstance";
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

export const apiClientService = {
  getAll: (endpoint, page = 1) =>
    handleApiCall(() =>
      clientAxiosInstance.get(`${endpoint}`, { params: { page } }),
    ),

  get: (endpoint, params = "") =>
    handleApiCall(() => clientAxiosInstance.get(`${endpoint}`, { params })),

  create: (endpoint, data, headers = {}) =>
    handleApiCall(() => clientAxiosInstance.post(endpoint, data, { headers })),

  update: (endpoint, slug, data, headers = {}) =>
    handleApiCall(() =>
      clientAxiosInstance.put(`${endpoint}/${slug}`, data, { headers }),
    ),

  find: (endpoint, slug) =>
    handleApiCall(() => clientAxiosInstance.get(`${endpoint}/${slug}`)),

  delete: (endpoint, slug) =>
    handleApiCall(() => clientAxiosInstance.delete(`${endpoint}/${slug}`)),

  search: (endpoint, keyword = "") =>
    handleApiCall(() =>
      clientAxiosInstance.get(endpoint, { params: { keyword } }),
    ),

  pluck: (endpoint) =>
    handleApiCall(() => clientAxiosInstance.get("/pluck" + endpoint)),
  getByUrl(url) {
    return handleApiCall(() => axios.get(url));
  },
};
