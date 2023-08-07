import BaseService from "./BaseService";
import http from "../commons/api.js";

/**
 * CateService
 * @extends BaseService
 * @class
 * @classdesc Service for categories
 */
class CateService extends BaseService {
    async getCates() {
        try {
            const response = await http.get(`/categories`);
            return response;
        } catch (error) {
            throw error;
        }
    }
}

export default new CateService();
