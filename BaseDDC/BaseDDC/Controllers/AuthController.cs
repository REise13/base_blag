using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using BaseDDC.model;
using System.Text;
using BaseDTO;
using Newtonsoft.Json;
using System.Security.Cryptography;
namespace BaseDDC.Controllers
{
    [Route("Auth")]
    [ApiController]
    public class AuthController : ControllerBase
    {
        
        [Route("Get")]
        [HttpGet]
        public IActionResult Get()
        {
            using (var db = new baseddcContext())
            {
                List<User> users = db.User.
                    Include(x=>x.Role).
                    ToList();
                if (users != null)
                {
                    try
                    {
                        List<DTO_User_Get> result = AutoMapper.Mapper.Map<List<User>, List<DTO_User_Get>>(users);
                        return Ok(result);
                    }
                    catch (Exception ex)
                    {
                        return BadRequest(ex.Message);
                    }
                }
                else return BadRequest("Пользователей нет");
            }
        }
        [HttpGet]
        [Route("getKey/{login}")]
        public IActionResult Get(string login)
        {
            using (var dbconext = new baseddcContext())
            {
                User user = dbconext.User.Where(u => u.Login == login).FirstOrDefault();
                if (user != null)
                {
                    string key = Guid.NewGuid().ToString();
                    user.Salt = key;
                    dbconext.SaveChanges();
                    return Ok(user.Salt);
                }
                else return BadRequest("Такого пользователя не существует");
            }
        }
        [HttpPost]
        [Route("postPass/{login}")]
        public IActionResult PostPass(string login, [FromBody] string pass)
        {
            using (var dbconext = new baseddcContext())
            {
                User user = dbconext.User
                    .Where(u => u.Login == login)
                    .Include(x=>x.Role)
                    .FirstOrDefault();
                if (user != null)
                {
                    string hash = getHash(user.Pass + user.Salt);
                    if (hash == pass)
                    {
                        string token = Guid.NewGuid().ToString();
                        user.Token = token;
                        user.Salt = "";
                        dbconext.SaveChanges();                     
                        return Ok(AutoMapper.Mapper.Map<User, DTO_User_Auth>(user));
                    }
                    else return BadRequest(hash +"  " + pass);
                }
                else return NoContent();
            }

        }

        static public string getHash(string inputString)
        {
            SHA512 sha512 = SHA512Managed.Create();
            byte[] bytes = Encoding.UTF8.GetBytes(inputString);
            byte[] hash = sha512.ComputeHash(bytes);
            return GetStringFromHash(hash);
        }

        static private string GetStringFromHash(byte[] hash)
        {
            StringBuilder result = new StringBuilder();
            for (int i = 0; i < hash.Length; i++)
            {
                result.Append(hash[i].ToString("X2"));
            }
            return result.ToString();
        }
    }
   
}