import $http from "./$http";

export default class SchedulingApi {
    static async getExpertInfo(expertId){
        return {};
    }

    static async getTimeSlots(expert, timezone, date, duration){
        return [{start: "10:00", end: "11:00"}];
    }
}
