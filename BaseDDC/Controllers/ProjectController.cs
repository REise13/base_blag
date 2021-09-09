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
    [Route("Project")]
    [ApiController]
    public class ProjectController : ControllerBase
    {
        public readonly baseddcContext _context = new baseddcContext();
        [HttpPost]
        [Route("Get")]
        public IActionResult Get([FromBody] DTO_Auth_Obj t)
        {
            try
            {
                List<DTO_Project_Get> result = new List<DTO_Project_Get>();
                List<Project> a = _context.Project.ToList();
                AutoMapper.Mapper.Map(a, result);
                return Ok(result);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }


        [HttpPost]
        [Route("Add")]
        public IActionResult Add([FromBody] DTO_Auth_Obj t)
        {
            DTO_Project_Add a = new DTO_Project_Add();
            try
            {
                a = JsonConvert.DeserializeObject<DTO_Project_Add>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удаётся распознать полученный объект");
            }
            try
            {
                Project result = new Project();
                AutoMapper.Mapper.Map(a, result);
                _context.Project.Add(result);
                _context.SaveChanges();
                return Ok(result);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }
    }
}