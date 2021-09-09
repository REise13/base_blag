using BaseDTO;
using Newtonsoft.Json;
using RestSharp;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Threading.Tasks;

namespace WpfApp_
{
    static class StaticInfoCollections
    {
        static public InfoCollection InfoCollections;
        
        static public void GetInfoCollections()
        {
            try
            {
                IRestResponse<InfoCollection> response = RestAPI.PostRest<InfoCollection>("/Collections/Get");
                InfoCollections = response.Data;
            }
            catch (Exception ex)
            {
                throw ex;
            }
        }
    }
}
