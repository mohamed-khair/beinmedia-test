import $http from "./$http";
import queryString from "query-string";

export default class SchedulingApi {
    static async submitRequest(expert_id, client_name, date, start_time, end_time, timezone){
        const body = {
            expert_id, client_name, date, start_time, end_time, timezone
        }
        return (await $http.post("schedule", body)).data;
    }

    static async getTimeSlots(expert_id, timezone, date, duration){
        const qs = {
            expert_id,
            timezone,
            date,
            duration
        }
        return (await $http.get(`available-slots?${queryString.stringify(qs)}`)).data;
    }
}
