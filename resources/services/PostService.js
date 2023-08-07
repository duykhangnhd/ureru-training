import BaseService from "./BaseService";
import http from "../commons/api.js";

/**
 * PostService
 * @extends BaseService
 * @class
 * @classdesc Service for posts
 */
export default new (class PostService extends BaseService {
    /**
     * getPosts
     * @param {*} filters
     * @returns
     */
    async getPosts(filters = {}) {
        try {
            const response = await http.get("/posts", {
                params: filters,
            });
            return response;
        } catch (error) {
            throw error;
        }
    }

    /**
     * searchPosts
     * @param {*} searchData
     * @returns
     */
    async searchPosts(searchData = {}, params = {}) {
        try {
            const response = await http.post("/posts/search", searchData, {
                params,
            });
            return response;
        } catch (error) {
            throw error;
        }
    }

    /**
     * getPostById
     * @param {*} id
     * @returns
     * @memberof PostService
     */
    async getPost(id) {
        try {
            const response = await http.get(`/posts/${id}`);
            return response;
        } catch (error) {
            throw error;
        }
    }

    /**
     * createPost
     * @param {*} postData
     * @returns
     */
    async createPost(postData, onSuccess, onFailed) {
        try {
            const response = await http.post(`/posts`, postData);
            return onSuccess("Create success");
        } catch (error) {
            return onFailed(error);
        }
    }

    /**
     * createPost
     * @param {*} post
     * @returns
     * @memberof PostService
     * @todo
     */
    async deletePost(id) {
        try {
            const response = await http.delete(`/posts/${id}`);
            return response;
        } catch (error) {
            throw error;
        }
    }

    /**
     * updatePost
     * @param {*} id
     * @param {*} postData
     * @returns
     */
    async updatePost(id, postData, onSuccess, onFailed) {
        try {
            const response = await http.put(`/posts/${id}`, postData);
            return onSuccess("Update success");
        } catch (error) {
            return onFailed(error);
        }
    }
})();
