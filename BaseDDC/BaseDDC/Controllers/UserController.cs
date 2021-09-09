using System;
using System.Collections.Generic;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using Newtonsoft.Json;
using AutoMapper;
using BaseDDC.model;
using BaseDTO;
namespace BaseDDC.Controllers
{
    [Route("User")]

    public class UserController : ControllerBase
    {
        baseddcContext _context = new baseddcContext();
        [HttpPost]
        [Route("All")]
        public IActionResult getAllUsers([FromBody] DTO_Auth_Obj t)
        {
            
            try
            {
                List<User> users = _context.User
                    .Include(u => u.Role)
                    .ToList();
                List<DTO_User_Get> AllUsers = Mapper.Map<List<User>, List<DTO_User_Get>>(users);
                return Ok(AllUsers);
            }
            catch (Exception e)
            {
                return BadRequest(e.Message);
            }
        }

        [HttpPost]
        [Route("ById/{id}")]
        public IActionResult ById([FromBody] DTO_Auth_Obj t, int id)
        {
            try
            {
                DTO_User_Get result = Mapper.Map<User, DTO_User_Get>(_context.User.Find(id));
                if (result != null) return Ok(result);
                else return NotFound();
            }
            catch (Exception e)
            {
                return BadRequest(e.Message);
            }
        }

        [HttpPost]
        [Route("Create")]
        public IActionResult AddUser([FromBody] DTO_Auth_Obj t)
        {
            DTO_User_Create user;
            try
            {
                user = JsonConvert.DeserializeObject<DTO_User_Create>(t.obj.ToString());
            }
            catch (Exception e)
            {
                return BadRequest(e.Message);
            }
            try
            {
                if (_context.User.Any(e => e.Login == user.Login)) return BadRequest("Такой пользователь уже существует");
                User newuser = Mapper.Map<DTO_User_Create, User>(user);
                _context.Add(newuser);
                _context.SaveChanges();
                return Ok("Пользователь добавлен");
            }
            catch (Exception e)
            {
                return BadRequest(e.Message);
            }
        }
        
        private bool TuserExists(int id)
        {
            return _context.User.Any(e => e.Id == id);
        }
    }
}
