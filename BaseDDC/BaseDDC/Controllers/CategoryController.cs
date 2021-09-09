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
    [Route("Category")]
    [ApiController]
    public class CategoryController : ControllerBase
    {
        public readonly baseddcContext _context = new baseddcContext();

        [HttpPost]
        [Route("Add")]
        public IActionResult Add([FromBody] DTO_Auth_Obj t)
        {
            DTO_Category a;
            Category b;
            try
            {
                a = JsonConvert.DeserializeObject<DTO_Category>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удаётся распознать полученный объект");
            }
            try
            {
                b = new Category()
                {
                    Title = a.title
                };
                _context.Category.Add(b);
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
            DTO_Category a;
            Category b;
            try
            {
                a = JsonConvert.DeserializeObject<DTO_Category>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удаётся распознать полученный объект");
            }
            try
            {
                b = _context.Category.Find(a.id);
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
            Category b;
            try
            {
                b = _context.Category.Find(id);
                _context.Category.Remove(b);
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