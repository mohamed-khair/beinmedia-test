import $http from "./$http";

export default class ExpertsApi {
    static async getExperts(){
        return (await $http.get(`/experts`)).data;
    }

    static async getExpert(expertId){
        return (await $http.get(`/experts/${expertId}`)).data;
    }
}
