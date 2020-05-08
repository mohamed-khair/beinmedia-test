import $http from "./$http";

export default class TimezoneApi {
    static async getUserTimezone(){
        return (await $http.get("timezone")).data;
    }
    static async getTimezones(){
        const timezones = (await $http.get("/timezones")).data;
        return timezones.map(timezone => ({text: timezone, value: timezone}));
    }
}
