import { apiService } from "@/services/apiService";

export const dashboardService = {
  getOverview() {
    return apiService.getAll('/overview');
  },
};
