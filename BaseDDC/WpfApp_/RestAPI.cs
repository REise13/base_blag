using System.Windows;
using System.Net.Http;
using System.Runtime.Serialization;
using Newtonsoft.Json;
using BaseDTO;
using System.Collections.Generic;
using System.Net.Http.Headers;
using System.Text.RegularExpressions;
using System;
using RestSharp;
using System.Threading.Tasks;
using System.Net;

namespace WpfApp_
{
    public static class RestAPI
    {
        public static DTO_Auth_Obj RequestUserObj { get; private set; }
        public static DTO_User_Auth User { get; private set; }

        static RestAPI()
        {
            RequestUserObj = null;
        }
        
        public static IRestResponse<T> PostRest<T>(string route, object requestObject = null) where T : new()
        {
            var client = new RestSharp.RestClient(Config.Connection + route);
            var request = new RestSharp.RestRequest(RestSharp.Method.POST);
            request.AddHeader("POST", "application/json");
            request.OnBeforeDeserialization = resp => { resp.ContentType = "application/json"; };
            if (RequestUserObj == null)
            {
                request.AddJsonBody(requestObject);
            }
            else
            {
                RequestUserObj.obj = requestObject;
                request.AddJsonBody(RequestUserObj);
            }
            return client.Execute<T>(request);
        }

        public static IRestResponse PostRest(string route, object requestObject = null)
        {
            var client = new RestSharp.RestClient(Config.Connection + route);
            var request = new RestSharp.RestRequest(RestSharp.Method.POST);
            request.AddHeader("POST", "application/json");
            request.OnBeforeDeserialization = resp => { resp.ContentType = "application/json"; };
            if (RequestUserObj == null)
            {
                request.AddJsonBody(requestObject);
            }
            else
            {
                RequestUserObj.obj = requestObject;
                request.AddJsonBody(RequestUserObj);
            }
            return client.Execute(request);
        }

        public static async Task<IRestResponse<T>> GetRestAsync<T>(string route, object obj = null)
        {
            var client = new RestSharp.RestClient(Config.Connection + route);
            var request = new RestSharp.RestRequest(RestSharp.Method.GET);
            request.AddHeader("GET", "application/json");
            request.OnBeforeDeserialization = resp => { resp.ContentType = "application/json"; };

            Task<IRestResponse<T>> task = client.ExecuteGetTaskAsync<T>(request);
            return await task;
        }

        public static IRestResponse<T> GetRest<T>(string route, object obj = null) where T:new()
        {
            var client = new RestSharp.RestClient(Config.Connection + route);
            var request = new RestSharp.RestRequest(RestSharp.Method.GET);
            request.AddHeader("GET", "application/json");
            request.OnBeforeDeserialization = resp => { resp.ContentType = "application/json"; };
            return client.Execute<T>(request);
        }
        public static IRestResponse GetRest(string route, object obj = null)
        {
            var client = new RestSharp.RestClient(Config.Connection + route);
            var request = new RestSharp.RestRequest(RestSharp.Method.GET);
            request.AddHeader("GET", "application/json");
            request.OnBeforeDeserialization = resp => { resp.ContentType = "application/json"; };
            return client.Execute(request);
        }
        public static async Task<IRestResponse<T>> PostRestAsync<T>(string route, object requestObject = null)
        {
            var client = new RestSharp.RestClient(Config.Connection + route);
            var request = new RestSharp.RestRequest(RestSharp.Method.POST);
            request.AddHeader("POST", "application/json");
            request.OnBeforeDeserialization = resp => { resp.ContentType = "application/json"; };
            if(RequestUserObj == null)
            {
                request.AddJsonBody(requestObject);
            }
            else
            {
                RequestUserObj.obj = requestObject;
                request.AddJsonBody(RequestUserObj);
            }
            var q = JsonConvert.SerializeObject(requestObject);
            Task<IRestResponse<T>> task = client.ExecutePostTaskAsync<T>(request);
            return await task;
        }

        public static void SetRequestUserObject(DTO_Auth_Obj requestUserObject)
        {
            RequestUserObj = new DTO_Auth_Obj() { user_id = requestUserObject.user_id, token = requestUserObject.token };
        }

        public static void SetUserAuth(DTO_User_Auth user)
        {
            User = user;
        }
    }
}
