import * as yup from "yup";

export const formSchema = yup.object({
  name: yup.string().max(255).required("Title is required"),
  slug: yup.string().max(255).required("Slug is required"),
  link_embed: yup.string().max(255).required("Link is required"),
});
