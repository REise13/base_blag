using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using BaseDDC.model;
using BaseDTO;
using Newtonsoft.Json;
namespace BaseDDC.Controllers
{
    [Route("Need")]
    [ApiController]
    public class NeedController : ControllerBase
    {
        public readonly baseddcContext _context = new baseddcContext();

        [HttpPost]
        [Route("Add")]
        public IActionResult Add([FromBody] DTO_Auth_Obj t)
        {
            DTO_Need a;
            Need b;
            try
            {
                a = JsonConvert.DeserializeObject<DTO_Need>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удаётся распознать полученный объект");
            }
            try
            {
                b = new Need()
                {
                    Title = a.title
                };
                _context.Need.Add(b);
                _context.SaveChanges();
                return Ok(b.Id);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

        [HttpPost]
        [Route("Edit")]
        public IActionResult Edit([FromBody] DTO_Auth_Obj t)
        {
            DTO_Need a;
            Need b;
            try
            {
                a = JsonConvert.DeserializeObject<DTO_Need>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удаётся распознать полученный объект");
            }
            try
            {
                b = _context.Need.Find(a.id);
                b.Title = a.title;
                _context.SaveChanges();
                return Ok();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }

        }
        [HttpPost]
        [Route("Delete/{id}")]
        public IActionResult Delete([FromBody] DTO_Auth_Obj t, int id)
        {
            Need b;
            try
            {
                b = _context.Need.Find(id);
                _context.Need.Remove(b);
                _context.SaveChanges();
                return Ok();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }
    }
}