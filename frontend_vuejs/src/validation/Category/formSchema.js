import * as yup from "yup";

export const formSchema = yup.object({
  title: yup.string().max(255).required("Title is required"),
  slug: yup.string().max(255).required("Slug is required"),
  description: yup.string().required("Description is required"),
  status: yup.number().oneOf([0, 1]).required("Status is required"),
});
